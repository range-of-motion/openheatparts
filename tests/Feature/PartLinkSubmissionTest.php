<?php

use App\Models\Brand;
use App\Models\PartLink;
use App\Models\UnitPart;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->unitPart = UnitPart::factory()->create();
    $this->unit = $this->unitPart->unit;
    $this->brand = $this->unit->brand;
    $this->part = $this->unitPart->part;
    $this->storeUrl = route('part-links.store', [$this->brand, $this->unit, $this->part]);
});

test('a guest can submit a link that awaits review', function () {
    $response = $this->post($this->storeUrl, [
        'url' => 'https://shop.example.com/compressor',
        'shop_name' => 'Example Shop',
    ]);

    $response->assertRedirect(route('units.show', [$this->brand, $this->unit, $this->part]))
        ->assertSessionHas('status');

    $link = PartLink::sole();

    expect($link->unit_part_id)->toBe($this->unitPart->id)
        ->and($link->user_id)->toBeNull()
        ->and($link->approved_at)->toBeNull()
        ->and($link->url)->toBe('https://shop.example.com/compressor')
        ->and($link->shop_name)->toBe('Example Shop');
});

test('a submitted link cannot approve itself', function () {
    $this->post($this->storeUrl, [
        'url' => 'https://shop.example.com/compressor',
        'shop_name' => 'Example Shop',
        'approved_at' => now()->toDateTimeString(),
    ]);

    expect(PartLink::sole()->approved_at)->toBeNull();
});

test('only approved links are shown on the unit page', function () {
    PartLink::factory()->for($this->unitPart)->create(['shop_name' => 'Approved Shop']);
    PartLink::factory()->for($this->unitPart)->pending()->create(['shop_name' => 'Pending Shop']);

    $this->get(route('units.show', [$this->brand, $this->unit, $this->part]))
        ->assertOk()
        ->assertSee('Approved Shop')
        ->assertDontSee('Pending Shop');
});

test('submissions are validated', function (array $payload, string $field) {
    $this->post($this->storeUrl, $payload)->assertSessionHasErrors($field);

    expect(PartLink::count())->toBe(0);
})->with([
    'missing url' => [['shop_name' => 'Example Shop'], 'url'],
    'invalid url' => [['url' => 'not a url', 'shop_name' => 'Example Shop'], 'url'],
    'javascript url' => [['url' => 'javascript:alert(1)', 'shop_name' => 'Example Shop'], 'url'],
    'ftp url' => [['url' => 'ftp://shop.example.com/file', 'shop_name' => 'Example Shop'], 'url'],
    'missing shop name' => [['url' => 'https://shop.example.com'], 'shop_name'],
    'shop name too long' => [['url' => 'https://shop.example.com', 'shop_name' => str_repeat('a', 101)], 'shop_name'],
    'honeypot filled' => [['url' => 'https://shop.example.com', 'shop_name' => 'Example Shop', 'website' => 'spam'], 'website'],
]);

test('a link cannot be submitted for a part that is not on the unit', function () {
    $otherPart = UnitPart::factory()->create()->part;

    $this->post(route('part-links.store', [$this->brand, $this->unit, $otherPart]), [
        'url' => 'https://shop.example.com',
        'shop_name' => 'Example Shop',
    ])->assertNotFound();

    expect(PartLink::count())->toBe(0);
});

test('a link cannot be submitted for a unit under another brand', function () {
    $otherBrand = Brand::factory()->create();

    $this->post(route('part-links.store', [$otherBrand, $this->unit, $this->part]), [
        'url' => 'https://shop.example.com',
        'shop_name' => 'Example Shop',
    ])->assertNotFound();

    expect(PartLink::count())->toBe(0);
});

test('submissions are rate limited', function () {
    $payload = ['url' => 'https://shop.example.com', 'shop_name' => 'Example Shop'];

    foreach (range(1, 5) as $attempt) {
        $this->post($this->storeUrl, $payload)->assertRedirect();
    }

    $this->post($this->storeUrl, $payload)->assertTooManyRequests();

    expect(PartLink::count())->toBe(5);
});

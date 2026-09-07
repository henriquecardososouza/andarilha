<?php

namespace App\Services;

use App\Data\Destination;
use App\Data\Review;
use Illuminate\Support\Collection;

final class DestinationCatalog
{
    /**
     * @return Collection<int, Destination>
     */
    public function all(): Collection
    {
        return collect([
            new Destination(
                slug: 'tokyo',
                photo: 'tokyo.png',
                iconNames: ['torii', 'blossom', 'ramen'],
                reviews: [
                    new Review('tokyo', 'marina', 'Marina Alves', 5),
                    new Review('tokyo', 'rafael', 'Rafael Tanaka', 4),
                ],
            ),
            new Destination(
                slug: 'paris',
                photo: 'paris.png',
                iconNames: ['eiffel', 'wine', 'palette'],
                reviews: [
                    new Review('paris', 'camila', 'Camila Duarte', 5),
                    new Review('paris', 'pedro', 'Pedro Nogueira', 4),
                ],
            ),
            new Destination(
                slug: 'new-york',
                photo: 'new york.png',
                iconNames: ['skyline', 'torch', 'ticket'],
                reviews: [
                    new Review('new-york', 'bianca', 'Bianca Rocha', 4),
                    new Review('new-york', 'thiago', 'Thiago Menezes', 5),
                ],
            ),
            new Destination(
                slug: 'rio',
                photo: 'rio de janeiro.png',
                iconNames: ['sugarloaf', 'wave', 'music'],
                reviews: [
                    new Review('rio', 'larissa', 'Larissa Prado', 5),
                    new Review('rio', 'gustavo', 'Gustavo Lima', 5),
                ],
            ),
            new Destination(
                slug: 'london',
                photo: 'london.png',
                iconNames: ['clock-tower', 'tea', 'bus'],
                reviews: [
                    new Review('london', 'helena', 'Helena Castro', 4),
                    new Review('london', 'bruno', 'Bruno Vieira', 5),
                ],
            ),
            new Destination(
                slug: 'la-paz',
                photo: 'la paz.png',
                iconNames: ['summit', 'cable-car', 'market'],
                reviews: [
                    new Review('la-paz', 'sofia', 'Sofía Quiroga', 5),
                    new Review('la-paz', 'andre', 'André Salles', 4),
                ],
                isBackdrop: true,
            ),
        ]);
    }

    public function find(string $slug): ?Destination
    {
        return $this->all()->firstWhere('slug', $slug);
    }

    /**
     * Destinations paired with the display index the carousels print.
     *
     * @return Collection<int, array{destination: Destination, index: int, number: string}>
     */
    public function slides(): Collection
    {
        return $this->all()->values()->map(fn (Destination $destination, int $index) => [
            'destination' => $destination,
            'index' => $index,
            'number' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
        ]);
    }

    /**
     * Two named destinations, for layouts that show a pair of photos.
     *
     * @return Collection<int, Destination>
     */
    public function pair(string $first, string $second): Collection
    {
        return collect([$this->find($first), $this->find($second)])->filter()->values();
    }

    /**
     * Destination whose photo backs the contact section.
     */
    public function backdrop(): ?Destination
    {
        return $this->all()->first(fn (Destination $destination) => $destination->isBackdrop);
    }
}

<?php

namespace App\Filament\Resources\BannerAdvertisementResource\Pages;

use App\Filament\Resources\BannerAdvertisementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBannerAdvertisements extends ListRecords
{
    protected static string $resource = BannerAdvertisementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

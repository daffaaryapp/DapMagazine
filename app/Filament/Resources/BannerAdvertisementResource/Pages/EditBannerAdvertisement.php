<?php

namespace App\Filament\Resources\BannerAdvertisementResource\Pages;

use App\Filament\Resources\BannerAdvertisementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBannerAdvertisement extends EditRecord
{
    protected static string $resource = BannerAdvertisementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

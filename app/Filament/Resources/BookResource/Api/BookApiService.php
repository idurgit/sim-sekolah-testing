<?php
namespace App\Filament\Resources\BookResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\BookResource;
use Illuminate\Routing\Router;


class BookApiService extends ApiService
{
    protected static string | null $resource = BookResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}

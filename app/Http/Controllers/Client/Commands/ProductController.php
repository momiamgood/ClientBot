<?php

namespace App\Http\Controllers\Client\Commands;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

class ProductController extends Controller
{
    public function __invoke(Nutgram $bot)
    {
        $bot->sendMessage(text: $this->createCatalog());
    }

    public function createCatalog(): Application
    {
        $products = Product::all();

        return view('catalog.catalog', [
            'products' => $products
        ]);
    }
}

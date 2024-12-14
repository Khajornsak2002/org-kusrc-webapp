<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Your logic here
        return view('inventory.index'); // Ensure this view exists
    }

    public function showInventory()
    {
        $items = Item::all(); // Assuming you have an Item model
        return view('inventory', compact('items'));
    }
}

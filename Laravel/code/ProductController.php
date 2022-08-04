<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //permet de récupérer toutes les produits de la base de données
    public function index()
    {
        $Products = Product::All();
        return View('welcome', ['produits' => $Products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * Permet de créer un produit
     */
    public function store(Request $request)
    {
        $Product = new Product();
        $Product->name=$request->name;
        $Product->price=$request->price;
        $Product->save();
    }

   
    /**
     * Display the specified resource.
     *permet de récupérer un seul produit dont l'id passez en paramètre
     */
    public function show($id)
    {
        $Product= Product::find($id);
        return response()->json($Product);
    }

    /**
    
     * permet de modifier les données d'un produit
     */
    public function update(Request $request, $id)
    {
        $Product = Product::find($id);
        $Product->name = $request->name;
        $Product->price = $request->price;
        $Product->save();
    }

    /**
     * Remove the specified resource from storage.
    *permet de suprimer un produit
     */
    public function destroy($id)
    {
        $Product = Product::find($id)->delete();
    }
}

<?php

namespace App\Controllers;

use App\Controller;
use App\Errors\ExceptionDb;
use App\Models\Products;
use PDO;

class ProductsController extends Controller
{

    public function index($request, $responce)
    {
        try {
            $products = Products::findAll();
        } catch (ExceptionDb $e) {
            return $responce->withStatus(500);
        }

        if (!$products){
            return $responce->withStatus(204);
        }
        return $responce->withJson($products, 200);
    }

    public function show($request, $responce, $args)
    {
        try {
            $product = Products::findById($args['id']);
        } catch (ExceptionDb $e) {
            return $responce->withStatus(500);
        }

        if (!$product) {
            return $responce->withStatus(404);
        }
        return $responce->withJson($product, 200);
    }

    public function create($request, $responce)
    {
        if ('application/json' != $request->getContentType()) {
            return $responce->withStatus(415);
        }

        $data = $request->getParsedBody();

        if ($data && isset($data['title']) && isset($data['price'])) {

            try {
                $product = new Products();
            } catch (ExceptionDb $e) {
                return $responce->withStatus(500);
            }

            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];

            try {
                $product->save();
            } catch (ExceptionDb $e) {
                return $responce->withStatus(500);
            }

            return $responce->withStatus(201);
        }

        return $responce->withStatus(400);
    }

    public function update($request, $responce, $args)
    {
        if ('application/json' != $request->getContentType()) {
            return $responce->withStatus(415);
        }

        try{
            $product = Products::findById($args['id']);
        } catch (ExceptionDb $e) {
            return $responce->withStatus(500);
        }

        if (!$product) {
            return $responce->withStatus(404);
        }

        $data = $request->getParsedBody();
        if ($data) {
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];

            try {
                $product->save();
            } catch (ExceptionDb $e) {
                return $responce->withStatus(500);
            }

            return $responce->withStatus(204);
        }

        return $responce->withStatus(400);
    }

    public function delete($request, $responce, $args)
    {
        try{
            $product = Products::findById($args['id']);
        } catch (ExceptionDb $e) {
            return $responce->withStatus(500);
        }

        if (!$product) {
            return $responce->withStatus(404);
        }

        try {
            $product->delete();
        } catch (ExceptionDb $e) {
            return $responce->withStatus(500);
        }

        return $responce->withStatus(204);
    }


}

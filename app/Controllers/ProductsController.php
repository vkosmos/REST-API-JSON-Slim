<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Products;
use PDO;

class ProductsController extends Controller
{

    public function index($request, $responce)
    {
        $products = Products::findAll();

        return $responce->withJson($products, 200);

//        $topics = $this->c->db->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, Products::class);
//        return $this->c->view->render($responce, 'topics/index.twig', compact('topics'));
//        return $responce->withJson($topics, 200);
//        return $responce->withJson(['error' => 'not exist'], 404);
//        return $this->c->view->render($responce, 'topics/index.twig', compact('topics'));
    }

    public function show($request, $responce, $args)
    {
        $product = Products::findById($args['id']);
        return $responce->withJson($product, 200);
    }

    public function create($request, $responce)
    {
        $data = $request->getParsedBody();

        //Проверить все переданные поля
        if ($data) {
            $product = new Products();
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->save();
            return $responce->withStatus(200);
        }

        return $responce->withStatus(400);

//        $product = Products::findById($args['id']);
//        $product->delete();
//        return $responce->withStatus(200);
    }

    public function update($request, $responce, $args)
    {
        $data = $request->getParsedBody();

        if ($data) {
            $product = Products::findById($args['id']);
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->save();
            return $responce->withStatus(200);
        }

        return $responce->withStatus(400);

    }

    public function delete($request, $responce, $args)
    {
        $product = Products::findById($args['id']);
        $product->delete();
        return $responce->withStatus(200);
    }


}

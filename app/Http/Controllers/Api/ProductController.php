<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/api/products",
     *      tags={"product"},
     *      summary="List of all products",
     *      operationId="index",
     *      @OA\Parameter(
     *            name="limit",
     *            in="query",
     *            description="How many item to return at one time",
     *            required=false
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="A page array of products",
     *          @OA\JsonContent(
     *              type = "array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Unexpedted Error",
     *          @OA\JsonContent()
     *      ),
     *      security={{"bearer_token":{}}},
     * 
     *  )
    */

    public function index(Request $request)
    {
        #return response()->json(Product::all(),200);
        #return response(Product::paginate(10),200);

        $offset = $request->has('offset') ? $request->query('offset'):0;
        $limit = $request->has('limit') ? $request->query('limit'):10;
        
        $queryBuilder = Product::query();
        if($request->has('q'))
            $queryBuilder->where('name','like','%'.$request->query('q').'%');
        
        if($request->has('sortBy'))
            $queryBuilder->orderBy($request->query('sortBy'),$request->query('sort','DESC'));

        $data = $queryBuilder->offset($offset)->limit($limit)->get();
        return response($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *      path="/api/products/",
     *      tags={"product"},
     *      summary="Create a product",
     *      operationId="store",
     *      @OA\RequestBody(
     *            description="Store a product",
     *            required=true,
     *            @OA\JsonContent(
     *              type = "array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="Product created response",
     *          @OA\JsonContent(
     *              type = "array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Unexpedted Error",
     *          @OA\JsonContent()
     *      )
     *  )
    */
    public function store(Request $request)
    {
       
        $product = new Product;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return response([
            'data'=> $product,
            'message' =>"Product created."

        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/api/products/{productId}",
     *      tags={"product"},
     *      summary="Info for a specific product",
     *      operationId="show",
     *      @OA\Parameter(
     *            name="productId",
     *            in="path",
     *            description="The id column of the product to retrieve",
     *            required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Product detail response",
     *          @OA\JsonContent(
     *              type = "array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Unexpedted Error",
     *          @OA\JsonContent()
     *      )
     *  )
    */

    public function show($id)
    {  
        $product = Product::find($id);
        if($product){
            return response($product,200);
        }else{
            return response(['message'=>'Product Not Found'],404);
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *      path="/api/products/{productId}",
     *      tags={"product"},
     *      summary="Update a product",
     *      operationId="update",
     *      @OA\Parameter(
     *            name="productId",
     *            in="path",
     *            description="The id column of the product to update",
     *            required=true
     *      ),
     *      @OA\RequestBody(
     *            description="Update a product",
     *            required=true,
     *            @OA\JsonContent(
     *              type = "array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Product updated response",
     *          @OA\JsonContent(
     *              type = "array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Unexpedted Error",
     *          @OA\JsonContent()
     *      )
     *  )
    */
    public function update(Request $request, Product $product)
    {
         //$input = $request->all();
        //$product->update($input);
        
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return response([
            'data'=> $product,
            'message' =>"Product updated."

        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *      path="/api/products/{productId}",
     *      tags={"product"},
     *      summary="Delete a product",
     *      operationId="Delete",
     *      @OA\Parameter(
     *            name="productId",
     *            in="path",
     *            description="The id column of the product to delete",
     *            required=true
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Product deleted response",
     *          @OA\JsonContent(
     *              type = "array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Unexpedted Error",
     *          @OA\JsonContent()
     *      )
     *  )
    */
    public function destroy(Product $product)
    {
        $product->delete();

        return response([
            'message' =>"Product deleted."

        ],200);
    }
}

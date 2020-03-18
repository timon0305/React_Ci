<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReactApi extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reactApi_model');
    }

    public function products()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $products = $this->reactApi_model->get_products();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($products));
    }

    public function getProduct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $productId = $this->input->post('productId');
        $product = $this->reactApi_model->get_product($productId);

        $productData = array(
            'id' => $product->id,
            'productName' => $product->product_name,
            'price' => $product->price,
            'sku' => $product->sku
        );
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($productData));
    }

    public function createProduct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: *");

        $formdata = json_decode(file_get_contents('php://input'), true);
        if( ! empty($formdata)) {

            $productName = $formdata['productName'];
            $sku = $formdata['sku'];
            $price = $formdata['price'];

            $productData = array(
                'product_name' => $productName,
                'price' => $price,
                'sku' => $sku,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s', time())
            );

            $id = $this->reactApi_model->insert_product($productData);

            $response = array(
                'status' => 'success',
                'message' => 'Product added successfully'
            );
        }
        else {
            $response = array(
                'status' => 'error'
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function editProduct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $formdata = json_decode(file_get_contents('php://input'), true);

        if( ! empty($formdata)) {

            $id = $formdata['id'];
            $productName = $formdata['productName'];
            $sku = $formdata['sku'];
            $price = $formdata['price'];

            $productData = array(
                'product_name' => $productName,
                'price' => $price,
                'sku' => $sku
            );

            $id = $this->reactApi_model->update_product($id, $productData);

            $response = array(
                'status' => 'success',
                'message' => 'Product updated successfully.'
            );
        }
        else {
            $response = array(
                'status' => 'error'
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function deleteProduct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $productId = $this->input->post('productId');

        $product = $this->reactApi_model->delete_product($productId);

        $response = array(
            'message' => 'Product deleted successfully.'
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
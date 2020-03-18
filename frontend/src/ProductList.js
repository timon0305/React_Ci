import React from 'react';
import {Table, Button, Alert} from 'react-bootstrap';

class ProductList extends React.Component{
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            products: [],
            response: {}
        }
    }
    componentDidMount() {
        const apiUrl = 'http://localhost/ci/index.php/reactapi/products';

        fetch(apiUrl, {
            method: 'GET',
            mode: 'cors',
            headers: {
                'Access-Control-Allow-Methods': 'DELETE',
                'Access-Control-Allow-Origin':'*',
                'Access-Control-Allow-Header':'*',
            },
        })
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        products: result
                    })
                },
                (error) => {
                    this.setState({error});
                }
            )
    }
    deleteProduct(productId) {
        const {products} = this.state;
        const apiUrl = 'http://localhost/ci/index.php/reactapi/deleteProduct';
        const formData = new FormData();
        formData.append('productId', productId);
        formData.append('Content-Type', 'application/json');
        formData.append('Access-Control-Allow-Methods', 'DELETE');
        formData.append('Access-Control-Allow-Origin', '*');
        formData.append('Access-Control-Allow-Header', '*');

        const options = {
            method: 'POST',
            body: formData
        };

        fetch(apiUrl, options)
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        response: result,
                        products: products.filter(product => product.id !== productId)
                    });
                },
                (error) => {
                    this.setState({error})
                }
            )
    }

    render() {
        const { error, products} = this.state;
        
        if (error) {
            return (
                <div>Error: {error.message}</div>
            )
        } else {
            return(
                <div>
                    <h2>Product List</h2>
                    {this.state.response.message && <Alert variant='info'>{this.state.response.message}</Alert>}
                    <Table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Product Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {products.map(product => (

                                <tr key={product.id}>
                                    <td>{product.id}</td>
                                    <td>{product.product_name}</td>
                                    <td>{product.sku}</td>
                                    <td>{product.price}</td>
                                    <td>
                                        <Button variant='info' onClick={() => this.props.editProduct(product.id)}>Edit</Button>
                                        &nbsp;<Button variant='danger' onClick={() => this.deleteProduct(product.id)}>Delete</Button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </Table>
                </div>
            )
        }
    }
}

export default ProductList;
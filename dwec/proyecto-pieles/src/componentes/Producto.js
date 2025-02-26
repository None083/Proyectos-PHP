import React from 'react';
import { Card, CardBody, CardText, CardTitle, Button } from 'reactstrap';

function Producto(props) {
    return (
        <Card style={{ width: '20rem' }} className="d-flex flex-column">
            <img src={props.img} alt={props.nombre} />
            <CardBody className="d-flex flex-column">
                <CardTitle tag="h5">{props.nombre}</CardTitle>
                <CardText>
                    {props.texto}
                </CardText>
                <div className='mt-auto'>
                    <strong>{props.precio}€</strong><br />
                    <Button className='mt-2 w-100' color='warning' onClick={() => props.clicar(props, 1)}>
                        Add to cart
                    </Button>
                </div>
            </CardBody>
        </Card>
    );
}

export default Producto;

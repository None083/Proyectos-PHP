import React from 'react';
import { Card, CardBody, CardText, CardTitle, Button } from 'reactstrap';

function Producto(props) {
    return (
        <Card style={{ width: '18rem' }} className="d-flex flex-column">
            <img src={props.img} alt={props.nombre} />
            <CardBody className="d-flex flex-column">
                <CardTitle tag="h5">{props.nombre}</CardTitle>
                <CardText>
                    {props.texto}
                </CardText>
                <div className='mt-auto'>
                    <strong>{props.precio}€</strong><br />
                    <Button className='mt-2' color="primary" onClick={() => props.clicar(props.id, 1)}>
                        Comprar
                    </Button>
                </div>
            </CardBody>
        </Card>
    );
}

export default Producto;

import React, { useState } from 'react';
import { Modal, ModalHeader, ModalBody, ModalFooter, Button, ListGroup, ListGroupItem, Form, FormGroup, Label, Input, Card, CardTitle, CardText, CardBody } from 'reactstrap';

const CarritoModal = ({ isOpen, toggle, carrito, modificar, guardarPedido }) => {
    const [pedidoData, setPedidoData] = useState({
        nombre: '',
        direccion: ''
    });

    const handleInputChange = (e) => {
        setPedidoData({
            ...pedidoData,
            [e.target.name]: e.target.value
        });
    };

    return (
        <Modal isOpen={isOpen} toggle={toggle}>
            <ModalHeader toggle={toggle}>🛒 Carrito de Compras</ModalHeader>
            <ModalBody>
                {carrito.length === 0 ? (
                    <p>Tu carrito está vacío.</p>
                ) : (
                    <ListGroup>
                        {carrito.map((producto, index) => (
                            <ListGroupItem key={index} className="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{producto.nombre}</strong>
                                    <span> ({producto.cantidad}x)</span>
                                </div>

                                <div className='d-flex flex-row-nowrap align-items-center mx-2'>
                                    <span>€{(producto.precio * producto.cantidad).toFixed(2)}</span>
                                    <Button className='me-1 mx-2' color='secondary' onClick={() => modificar(producto.nombre, -1)}>-</Button>
                                    <Button color='secondary' onClick={() => modificar(producto.nombre, 1)}>+</Button>
                                </div>
                            </ListGroupItem>
                        ))}
                    </ListGroup>
                )}

                <Card className="mt-3">
                    <CardBody>
                        <CardTitle tag="h5">Total</CardTitle>
                        <CardText>€{carrito.reduce((total, item) => total + item.precio * item.cantidad, 0).toFixed(2)}</CardText>
                    </CardBody>
                </Card>

                <Card className="mt-3">
                    <CardBody>
                        <CardTitle tag="h5">Información de Envío</CardTitle>
                        <Form>
                            <FormGroup>
                                <Label for="nombre">Nombre</Label>
                                <Input
                                    id="nombre"
                                    name="nombre"
                                    placeholder="Ingresa tu nombre"
                                    type="text"
                                    value={pedidoData.nombre}
                                    onChange={handleInputChange}
                                />
                            </FormGroup>
                            <FormGroup>
                                <Label for="direccion">Dirección</Label>
                                <Input
                                    id="direccion"
                                    name="direccion"
                                    placeholder="Ingresa tu dirección"
                                    type="text"
                                    value={pedidoData.direccion}
                                    onChange={handleInputChange}
                                />
                            </FormGroup>
                        </Form>
                    </CardBody>
                </Card>

            </ModalBody>
            <ModalFooter>
                <Button color="secondary" onClick={toggle}>Cerrar</Button>
                {carrito.length > 0 && (
                    <Button color="warning" onClick={() => guardarPedido(pedidoData)}>Pagar</Button>
                )}
            </ModalFooter>
        </Modal>
    );
};

export default CarritoModal;

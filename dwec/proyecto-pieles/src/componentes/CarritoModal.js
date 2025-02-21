import React from 'react';
import { Modal, ModalHeader, ModalBody, ModalFooter, Button, ListGroup, ListGroupItem } from 'reactstrap';

const CarritoModal = ({ isOpen, toggle, carrito }) => {
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
                                    <span className="ml-2">({producto.cantidad}x)</span>
                                </div>
                                <span>€{(producto.precio * producto.cantidad).toFixed(2)}</span>
                            </ListGroupItem>
                        ))}
                    </ListGroup>
                )}
            </ModalBody>
            <ModalFooter>
                <Button color="secondary" onClick={toggle}>Cerrar</Button>
                {carrito.length > 0 && <Button color="success">Finalizar Compra</Button>}
            </ModalFooter>
        </Modal>
    );
};

export default CarritoModal;

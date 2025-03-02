import React from 'react';
import { Modal, ModalHeader, ModalBody, ModalFooter, Button, ListGroup, ListGroupItem} from 'reactstrap';
import { FaBoxOpen } from 'react-icons/fa';

const PedidosModal = ({ isOpen, toggle, pedidos }) => {
    return (
      <Modal isOpen={isOpen} toggle={toggle}>
      <ModalHeader toggle={toggle}><FaBoxOpen size={20} /> Order History</ModalHeader>
      <ModalBody>
        {pedidos.length === 0 ? (
        <p>No orders placed.</p>
        ) : (
        <ListGroup>
          {pedidos.map((pedido, index) => (
          <ListGroupItem key={pedido.id}>
            <strong>Order {index + 1} - {pedido.fecha}</strong>
            <p><strong>Name:</strong> {pedido.envio.nombre}</p>
            <p><strong>Address:</strong> {pedido.envio.direccion}</p>
            <ul className='mb-3'>
            {pedido.productos.map((prod, i) => (
              <li key={i}>{prod.nombre} ({prod.cantidad}x) - €{(prod.precio * prod.cantidad).toFixed(2)}</li>
            ))}
            </ul>
            <strong >Total: €{pedido.total.toFixed(2)}</strong>
          </ListGroupItem>
          ))}
        </ListGroup>
        )}
      </ModalBody>
      <ModalFooter>
        <Button color="secondary" onClick={toggle}>Close</Button>
      </ModalFooter>
      </Modal>
    );
  };

export default PedidosModal;
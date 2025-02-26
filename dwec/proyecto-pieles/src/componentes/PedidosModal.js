import React from 'react';
import { Modal, ModalHeader, ModalBody, ModalFooter, Button, ListGroup, ListGroupItem} from 'reactstrap';

const PedidosModal = ({ isOpen, toggle, pedidos }) => {
    return (
      <Modal isOpen={isOpen} toggle={toggle}>
        <ModalHeader toggle={toggle}>📜 Historial de Pedidos</ModalHeader>
        <ModalBody>
          {pedidos.length === 0 ? (
            <p>No hay pedidos realizados.</p>
          ) : (
            <ListGroup>
              {pedidos.map((pedido, index) => (
                <ListGroupItem key={pedido.id}>
                  <strong>Pedido {index + 1} - {pedido.fecha}</strong>
                  <p><strong>Nombre:</strong> {pedido.envio.nombre}</p>
                  <p><strong>Dirección:</strong> {pedido.envio.direccion}</p>
                  <ul>
                    {pedido.productos.map((prod, i) => (
                      <li key={i}>{prod.nombre} ({prod.cantidad}x) - €{(prod.precio * prod.cantidad).toFixed(2)}</li>
                    ))}
                  </ul>
                  <strong>Total: €{pedido.total.toFixed(2)}</strong>
                </ListGroupItem>
              ))}
            </ListGroup>
          )}
        </ModalBody>
        <ModalFooter>
          <Button color="secondary" onClick={toggle}>Cerrar</Button>
        </ModalFooter>
      </Modal>
    );
  };

export default PedidosModal;
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import React, { Component } from 'react';
import axios from 'axios';
import { PHPLOGIN } from './componentes/datos';
import md5 from 'md5';
import Header from './componentes/Header';
import Footer from './componentes/Footer';
import ShowProductos from './componentes/ShowProductos';
import Login from './componentes/Login';
import CarritoModal from './componentes/CarritoModal';
import PedidosModal from './componentes/PedidosModal';

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      productos: [],
      isAuthenticated: false,
      mensaje: '',
      carrito: [],
      pedidos: [],
      categoriaSeleccionada: null,
      isOpen: false,
      modalOpenCarrito: false,
      modalOpenPedidos: false
    };
  }

  componentDidMount() {
    this.fetchProductos();
  }

  fetchProductos = () => {
    axios.get('/2daw/pieles.json')
      .then(response => {
        this.setState({ productos: response.data.productos });
      })
      .catch(error => console.error('Error al cargar los datos:', error));
  };

  logIn = (usuario, password) => {
    axios.post(PHPLOGIN, JSON.stringify({
      usuario: usuario,
      password: md5(password)
    }))
      .then(res => {
        if (res.data.mensaje === "Acceso correcto") {
          this.setState({ isAuthenticated: true });
        } else {
          this.setState({ mensaje: res.data.mensaje });
        }
      })
      .catch(err => {
        this.setState({ mensaje: "Error en la conexión al servidor" });
      });
  };

  toggleNavbar = () => {
    this.setState(prevState => ({ isOpen: !prevState.isOpen }));
  };
  
  toggleModalCarrito = () => {
    this.setState(prevState => ({ modalOpenCarrito: !prevState.modalOpenCarrito }));
  };

  toggleModalPedidos = () => {
    this.setState(prevState => ({ modalOpenPedidos: !prevState.modalOpenPedidos }));
  };

  agregar = (producto, cantidad) => {
    this.setState(prevState => {
      let nuevoCarrito = prevState.carrito.map(item => {
        if (item.nombre === producto.nombre) {
          return { ...item, cantidad: item.cantidad + cantidad }; 
        }
        return item;
      });
  
      // Solo agrega el producto si no existe en el carrito
      if (!nuevoCarrito.some(item => item.nombre === producto.nombre)) {
        nuevoCarrito.push({ ...producto, cantidad });
      }
  
      return { carrito: nuevoCarrito };
    });
  };
  

  seleccionarCategoria = (categoria) => {
    this.setState({ categoriaSeleccionada: categoria.toUpperCase() });
  };

  modificar = (productoNombre, cantidad) => {
    this.setState(prevState => {
      let nuevoCarrito = prevState.carrito.map(item => {
        if (item.nombre === productoNombre) { 
          return { ...item, cantidad: item.cantidad + cantidad };
        }
        return item;
      });
  
      // Elimina el producto si la cantidad llega a 0
      nuevoCarrito = nuevoCarrito.filter(item => item.cantidad > 0);
  
      return { carrito: nuevoCarrito };
    });
  };

  guardarPedido = (pedidoData) => {
    if (this.state.carrito.length === 0 || !pedidoData.nombre || !pedidoData.direccion) {
      alert("Por favor, completa la información de envío.");
      return;
    }
  
    const nuevoPedido = {
      id: Date.now(), // ID único basado en la fecha actual
      productos: [...this.state.carrito], // Copia los productos del carrito
      total: this.state.carrito.reduce((total, item) => total + item.precio * item.cantidad, 0),
      fecha: new Date().toLocaleString(),
      envio: pedidoData // Guarda la información del envío dentro del objeto pedido
    };
  
    this.setState(prevState => ({
      pedidos: [...prevState.pedidos, nuevoPedido], // Agrega el nuevo pedido
      carrito: [], // Vacía el carrito
      modalOpenCarrito: false // Cierra el modal
    }));
  };
  
  

  render() {
    if (!this.state.isAuthenticated) {
      return <Login onLogin={this.logIn} />;
    }

    const productosFiltrados = this.state.categoriaSeleccionada
      ? this.state.productos.filter(p => p.categoria.toUpperCase() === this.state.categoriaSeleccionada)
      : this.state.productos;

    return (
      <div className="App">
        <Header
          isOpen={this.state.isOpen}
          toggleNavbar={this.toggleNavbar}
          productos={this.state.productos}
          seleccionarCategoria={this.seleccionarCategoria}
          carrito={this.state.carrito}
          toggleModalCarrito={this.toggleModalCarrito}
          toggleModalPedidos={this.toggleModalPedidos} />

        <ShowProductos
          lista={productosFiltrados}
          agregar={this.agregar}
          categoria={this.state.categoriaSeleccionada} />

        <CarritoModal
          isOpen={this.state.modalOpenCarrito}
          toggle={this.toggleModalCarrito}
          carrito={this.state.carrito}
          modificar={this.modificar} 
          guardarPedido={this.guardarPedido} />

        <PedidosModal
          isOpen={this.state.modalOpenPedidos}
          toggle={this.toggleModalPedidos}
          pedidos={this.state.pedidos}/> 
          
        <Footer />
      </div>
    );
  }
}

export default App;

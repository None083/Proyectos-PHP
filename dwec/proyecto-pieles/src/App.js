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

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isOpen: false,
      productos: [],
      isAuthenticated: false,
      mensaje: '',
      carrito: [],
      categoriaSeleccionada: null,
      modalOpen: false
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

  toggleModal = () => {
    this.setState(prevState => ({ modalOpen: !prevState.modalOpen }));
  };

  modificar = (producto, cantidad) => {
    this.setState(prevState => {
      let nuevoCarrito = [...prevState.carrito];

      // Usamos el nombre del producto como identificador único
      let productoExistente = nuevoCarrito.find(item => item.nombre === producto.nombre);

      if (productoExistente) {
        // Si el producto ya está en el carrito, actualizamos la cantidad
        productoExistente.cantidad += cantidad;

        // Si la cantidad es menor o igual a 0, lo eliminamos del carrito
        if (productoExistente.cantidad <= 0) {
          nuevoCarrito = nuevoCarrito.filter(item => item.nombre !== producto.nombre);
        }
      } else if (cantidad > 0) {
        // Si el producto NO está en el carrito, lo agregamos con la cantidad inicial
        nuevoCarrito.push({ ...producto, cantidad });
      }

      return { carrito: nuevoCarrito };
    });
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
          toggleModal={this.toggleModal}
        />

        <ShowProductos lista={productosFiltrados} modificar={this.modificar} />

        <CarritoModal isOpen={this.state.modalOpen} toggle={this.toggleModal} carrito={this.state.carrito} />

        <Footer />
      </div>
    );
  }
}

export default App;

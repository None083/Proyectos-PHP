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

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isOpen: false,
      productos: [],
      isAuthenticated: false,
      mensaje: '',
      carrito: [],
      categoriaSeleccionada: null // Nueva variable de estado para categoría activa
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

  seleccionarCategoria = (categoria) => {
    this.setState({ categoriaSeleccionada: categoria });
  };

  modificar = (producto, cantidad) => {
    let c = this.state.carrito.map(e => {
      if (e.id === producto) { e.cantidad += cantidad; }
      return e;
    });
    this.setState({ carrito: c });
    console.log(c);
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
          seleccionarCategoria={this.seleccionarCategoria} // Pasamos la función a Header
        />

        <h2 style={{ color: "#191000", textAlign: "left", margin: "1rem", borderBottom: "1px solid #191000", paddingBottom: "0.5rem" }}>
          {this.state.categoriaSeleccionada ? this.state.categoriaSeleccionada : "Category"}
        </h2>

        <ShowProductos
          lista={productosFiltrados}
          modificar={this.modificar}
        />

        <Footer />
      </div>
    );
  }
}

export default App;

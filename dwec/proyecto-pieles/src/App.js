import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import React, { Component } from 'react';
import axios from 'axios';
import { PHPLOGIN, PHPGUARDARPEDIDO } from './componentes/datos';
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
      modalOpenPedidos: false,
      usuarioAutenticado: null
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
    console.log("Intentando iniciar sesión con:", usuario, password);

    axios.post(PHPLOGIN, JSON.stringify({
      usuario: usuario,
      password: md5(password)
    }))
      .then(res => {
        console.log("Respuesta del servidor:", res.data);

        if (res.data.mensaje === "Acceso correcto" || res.data.mensaje === "Usuario creado correctamente") {
          this.setState({
            isAuthenticated: true,
            usuarioAutenticado: {
              nombre: res.data.usuario,
              tipo: res.data.tipo // Guardamos el tipo de usuario
            }
          });
        } else {
          this.setState({ mensaje: res.data.mensaje });
        }
      })
      .catch(err => {
        console.error("Error en la conexión al servidor:", err);
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
    console.log("toggleModalPedidos");
    if (!this.state.modalOpenPedidos) {
      this.fetchPedidos(); // Cargar pedidos antes de abrir el modal
    }
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


  // Función para guardar pedido en el servidor
  guardarPedido = (pedidoData) => {

    if (this.state.carrito.length === 0 || !pedidoData.nombre || !pedidoData.direccion) {
      alert("Por favor, completa la información de envío.");
      return;
    }

    const nuevoPedido = {
      id: Date.now(),
      productos: [...this.state.carrito],
      total: this.state.carrito.reduce((total, item) => total + item.precio * item.cantidad, 0),
      fecha: new Date().toLocaleString(),
      envio: pedidoData
    };

    console.log("Pedido enviado:", JSON.stringify(nuevoPedido, null, 2));


    axios.post(PHPGUARDARPEDIDO, JSON.stringify(nuevoPedido))
      .then(res => {
        console.log("Respuesta del servidor:", res.data);
        if (res.data.mensaje === "Pedido guardado correctamente") {
          this.setState({ carrito: [], modalOpenCarrito: false });
        } else {

          alert(res.data.mensaje);
        }
        console.log(nuevoPedido);
      })
      .catch(err => {
        alert("Error en la conexión con el servidor");
      });
  };

  // Nueva función para obtener pedidos del servidor
  fetchPedidos = () => {
    axios.get(PHPGUARDARPEDIDO)
      .then(response => {
        if (response.data.pedidos) {
          this.setState({ pedidos: response.data.pedidos });
        } else {
          this.setState({ pedidos: [] });
        }
      })
      .catch(error => {
        console.error('Error al obtener los pedidos:', error);
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
          toggleModalCarrito={this.toggleModalCarrito}
          toggleModalPedidos={this.toggleModalPedidos}
          usuario={this.state.usuarioAutenticado} />

        <ShowProductos
          lista={productosFiltrados}
          agregar={this.agregar}
          categoria={this.state.categoriaSeleccionada} />

        <CarritoModal
          isOpen={this.state.modalOpenCarrito}
          toggle={this.toggleModalCarrito}
          carrito={this.state.carrito}
          modificar={this.modificar}
          guardarPedido={this.guardarPedido}
          usuario={this.state.usuarioAutenticado}/>

        <PedidosModal
          isOpen={this.state.modalOpenPedidos}
          toggle={this.toggleModalPedidos}
          pedidos={this.state.pedidos}
          usuario={this.state.usuarioAutenticado} />
          
        <Footer />
      </div>
    );
  }
}

export default App;

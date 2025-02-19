import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { useState, useEffect } from 'react';
import { Button, Container, Navbar, NavbarBrand, Nav, NavItem, NavLink, Collapse, NavbarToggler, Form, FormGroup, Label, Input } from 'reactstrap';
import axios from 'axios';
import { PHPLOGIN } from './componentes/datos';
import md5 from 'md5';

const Header = ({ isOpen, toggleNavbar, productos }) => {
  const [isCategoriesOpen, setIsCategoriesOpen] = useState(false); // Estado para abrir/cerrar categorías
  const categorias = [...new Set(productos.map((producto) => producto.categoria.toUpperCase()))];

  const toggleCategories = () => {
    setIsCategoriesOpen(!isCategoriesOpen); // Cambiar el estado para abrir/cerrar categorías
  };

  return (
    <Navbar style={{ backgroundColor: '#191000' }} dark expand="md">
      <NavbarBrand href="/">
        <img src={process.env.PUBLIC_URL + '/images/logo2.png'} alt="Logo" style={{ height: '60px' }} onError={(e) => e.target.style.display = 'none'} />
      </NavbarBrand>
      <NavbarToggler onClick={toggleNavbar} />
      <Collapse isOpen={isOpen} navbar>
        <Nav className="ml-auto" navbar>
          <NavItem className="mx-2">
            <NavLink href="#" style={{ color: '#f2dcb8' }} onMouseOver={(e) => e.target.style.color = 'white'} onMouseOut={(e) => e.target.style.color = '#f2dcb8'}>
              <strong>HOME</strong>
            </NavLink>
          </NavItem>
          <NavItem className="mx-2">
            <NavLink href="#" style={{ color: '#f2dcb8' }} onMouseOver={(e) => e.target.style.color = 'white'} onMouseOut={(e) => e.target.style.color = '#f2dcb8'}>
              <strong>ABOUT</strong>
            </NavLink>
          </NavItem>

          {/* Botón "Categorías" solo en dispositivos móviles */}
          <NavItem className="mx-2 d-md-none">
            <NavLink href="#" className="categories-button" onClick={toggleCategories} style={{ color: '#f2dcb8' }} onMouseOver={(e) => e.target.style.color = 'white'} onMouseOut={(e) => e.target.style.color = '#f2dcb8'}>
              <strong>CATEGORIES ▼</strong>
            </NavLink>
            <Collapse isOpen={isCategoriesOpen} navbar>
              <Nav className="ml-auto" navbar>
                {categorias.map((categoria, index) => (
                  <NavItem key={index} className="mx-2">
                    <NavLink href={`#${categoria}`} style={{ color: '#efe5d5', borderBottom: "1px solid #efe5d5" }} onMouseOver={(e) => e.target.style.color = 'white'} onMouseOut={(e) => e.target.style.color = '#efe5d5'}>
                      {categoria}
                    </NavLink>
                  </NavItem>
                ))}
              </Nav>
            </Collapse>
          </NavItem>

          {/* Categorías visibles en dispositivos de escritorio */}
          {categorias.map((categoria, index) => (
            <NavItem key={index} className="mx-2 d-none d-md-block">
              <NavLink href={`#${categoria}`} style={{ color: '#efe5d5' }} onMouseOver={(e) => e.target.style.color = 'white'} onMouseOut={(e) => e.target.style.color = '#efe5d5'}>
                {categoria}
              </NavLink>
            </NavItem>
          ))}
        </Nav>
      </Collapse>
    </Navbar>
  );
};

const Footer = () => (
  <footer className="text-center py-3 mt-5" style={{ backgroundColor: '#191000', color: '#EDD2A7' }}>
    <p>&copy; 2025 Leather for Artisans. All rights reserved.</p>
  </footer>
);

const Login = ({ onLogin }) => {
  const [usuario, setUsuario] = useState('');
  const [password, setPassword] = useState('');
  const [mensaje, setMensaje] = useState('');

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    if (name === "usuario") setUsuario(value);
    if (name === "password") setPassword(value);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onLogin(usuario, password);
  };

  return (
    <div className="login-container" style={{ marginTop: '50px' }}>
      <Container>
        <h2>Login</h2>
        {mensaje && <div className="alert alert-danger">{mensaje}</div>}
        <Form onSubmit={handleSubmit}>
          <FormGroup>
            <Label for="usuario">Usuario</Label>
            <Input
              type="text"
              name="usuario"
              id="usuario"
              placeholder="Ingresa tu usuario"
              value={usuario}
              onChange={handleInputChange}
            />
          </FormGroup>
          <FormGroup>
            <Label for="password">Contraseña</Label>
            <Input
              type="password"
              name="password"
              id="password"
              placeholder="Ingresa tu contraseña"
              value={password}
              onChange={handleInputChange}
            />
          </FormGroup>
          <Button type="submit" color="primary">Entrar</Button>
        </Form>
      </Container>
    </div>
  );
};

const App = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [productos, setProductos] = useState([]);
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [mensaje, setMensaje] = useState('');

  useEffect(() => {
    fetchProductos();
  }, []);

  const fetchProductos = () => {
    axios.get('/2daw/pieles.json')
      .then(response => {
        setProductos(response.data.productos);
      })
      .catch((error) => console.error('Error al cargar los datos:', error));
  };

  const logIn = (usuario, password) => {
    axios.post(PHPLOGIN, JSON.stringify({
      usuario: usuario,
      password: md5(password)
    }))
      .then(res => {
        if (res.data.mensaje === "Acceso correcto") {
          setIsAuthenticated(true);
        } else {
          setMensaje(res.data.mensaje);
        }
      })
      .catch(err => {
        setMensaje("Error en la conexión al servidor");
      });
  };

  const toggleNavbar = () => {
    setIsOpen(!isOpen);
  };

  if (!isAuthenticated) {
    return <Login onLogin={logIn} />;
  }

  return (
    <div className="App">
      <Header
        isOpen={isOpen}
        toggleNavbar={toggleNavbar}
        productos={productos}
      />

      <Container className="mt-4 text-center">
        <h1>Welcome to Leather for Artisans</h1>
        <Button color="secondary">Dale</Button>
      </Container>

      <Footer />
    </div>
  );
};

export default App;

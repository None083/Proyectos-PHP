import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Component } from 'react';
import { Button, Container, Navbar, NavbarBrand, Nav, NavItem, NavLink, Collapse, NavbarToggler, Form, FormGroup, Label, Input } from 'reactstrap';

class Header extends Component {
  render() {
    const { isOpen, toggleNavbar, productos } = this.props;
    const categorias = [...new Set(productos.map((producto) => producto.categoria.toUpperCase()))];

    return (
      <Navbar style={{ backgroundColor: '#191000' }} dark expand="md">
        <NavbarBrand href="/">
          <img src={process.env.PUBLIC_URL + '/images/logo2.png'} alt="Logo" style={{ height: '60px' }} onError={(e) => e.target.style.display = 'none'} />
        </NavbarBrand>
        <NavbarToggler onClick={toggleNavbar} />
        <Collapse isOpen={isOpen} navbar>
          <Nav className="ml-auto" navbar>
            <NavItem className="mx-2">
              <NavLink href="#" style={{ color: '#f2dcb8' }}><strong>HOME</strong></NavLink>
            </NavItem>
            <NavItem className="mx-2">
              <NavLink href="#" style={{ color: '#f2dcb8' }}><strong>ABOUT</strong></NavLink>
            </NavItem>
            {categorias.map((categoria, index) => (
              <NavItem key={index} className="mx-2">
                <NavLink href={`#${categoria}`} style={{ color: '#efe5d5' }}>{categoria}</NavLink>
              </NavItem>
            ))}
          </Nav>
        </Collapse>
      </Navbar>
    );
  }
}

const Footer = () => (
  <footer className="text-center py-3 mt-5" style={{ backgroundColor: '#191000', color: '#EDD2A7' }}>
    <p>&copy; 2025 Leather for Artisans. All rights reserved.</p>
  </footer>
);

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      username: '',
      password: '',
      error: ''
    };
  }

  handleChange = (e) => {
    this.setState({ [e.target.name]: e.target.value });
  };

  handleSubmit = (e) => {
    e.preventDefault();
    const { username, password } = this.state;

    fetch('http://localhost/auth.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ username, password })
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          this.props.onLogin();
        } else {
          this.setState({ error: data.message });
        }
      })
      .catch(() => this.setState({ error: 'Server error' }));
  };

  render() {
    return (
      <Container className="mt-5">
        <h2>Login</h2>
        <Form onSubmit={this.handleSubmit}>
          <FormGroup>
            <Label for="username">Username</Label>
            <Input type="text" name="username" id="username" onChange={this.handleChange} required />
          </FormGroup>
          <FormGroup>
            <Label for="password">Password</Label>
            <Input type="password" name="password" id="password" onChange={this.handleChange} required />
          </FormGroup>
          {this.state.error && <p style={{ color: 'red' }}>{this.state.error}</p>}
          <Button type="submit" color="primary">Login</Button>
        </Form>
      </Container>
    );
  }
}

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isOpen: false,
      productos: [],
      isAuthenticated: false
    };
  }

  componentDidMount() {
    this.fetchProductos();
  }

  fetchProductos = () => {
    fetch('/2daw/pieles.json')
      .then((response) => response.json())
      .then((data) => {
        this.setState({ productos: data.productos });
      })
      .catch((error) => console.error('Error al cargar los datos:', error));
  };

  toggleNavbar = () => {
    this.setState({ isOpen: !this.state.isOpen });
  };

  handleLogin = () => {
    this.setState({ isAuthenticated: true });
  };

  render() {
    if (!this.state.isAuthenticated) {
      return <Login onLogin={this.handleLogin} />;
    }

    return (
      <div className="App">
        <Header
          isOpen={this.state.isOpen}
          toggleNavbar={this.toggleNavbar}
          productos={this.state.productos}
        />

        <Container className="mt-4 text-center">
          <h1>Welcome to Leather for Artisans</h1>
          <Button color="secondary">Dale</Button>
        </Container>

        <Footer />
      </div>
    );
  }
}

export default App;
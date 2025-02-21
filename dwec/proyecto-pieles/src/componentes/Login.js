import React, { useState } from 'react';
import { Container, Button, FormGroup, Label, Form, Input } from 'reactstrap';

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

export default Login;

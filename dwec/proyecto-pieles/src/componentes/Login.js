import React, { useState } from 'react';
import { Container, Button, FormGroup, Label, Form, Input, Card, CardBody, CardTitle, Alert } from 'reactstrap';

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
        <div className="d-flex flex-column justify-content-center align-items-center vh-100" style={{ backgroundColor: '#191000' }}>
            <img src={process.env.PUBLIC_URL + '/images/logo2.png'} alt="Logo" style={{ height: '100px', marginBottom: "1rem" }} />
            <Container>
                <div className="d-flex justify-content-center w-100">
                    <Card className="shadow p-4" style={{ width: '22rem', borderRadius: '12px' }}>
                        <CardBody>
                            <CardTitle tag="h3" className="text-center mb-4" style={{color: "#191000"}}>Wellcome back</CardTitle>
                            {mensaje && <Alert color="danger" className="text-center">{mensaje}</Alert>}
                            <Form onSubmit={handleSubmit}>
                                <FormGroup>
                                    <Label for="usuario">Username</Label>
                                    <Input
                                        type="text"
                                        name="usuario"
                                        id="usuario"
                                        placeholder="Enter your username"
                                        value={usuario}
                                        onChange={handleInputChange}
                                    />
                                </FormGroup>
                                <FormGroup>
                                    <Label for="password">Password</Label>
                                    <Input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="Enter your password"
                                        value={password}
                                        onChange={handleInputChange}
                                    />
                                </FormGroup>
                                <Button type="submit" color="warning" className="w-100 mt-3" style={{ borderRadius: '8px' }}>
                                    Log in
                                </Button>
                            </Form>
                        </CardBody>
                    </Card>
                </div>
            </Container>
        </div>
    );
};

export default Login;

import React, { useState } from 'react';
import { Navbar, NavbarBrand, Nav, NavItem, NavLink, Collapse, NavbarToggler, DropdownToggle, DropdownMenu, DropdownItem, Dropdown, Button } from 'reactstrap';
import { FaBox, FaBoxOpen, FaShoppingCart, FaUser } from 'react-icons/fa';

const Header = ({ isOpen, toggleNavbar, productos, seleccionarCategoria, carrito, toggleModalCarrito, toggleModalPedidos }) => {
    const [isCategoriesOpen, setIsCategoriesOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);

    const categorias = [...new Set(productos.map((producto) => producto.categoria.toUpperCase()))];

    const toggleCategories = () => setIsCategoriesOpen(!isCategoriesOpen);
    const toggleDropdown = () => setDropdownOpen(!dropdownOpen);

    const categoriasVisibles = categorias.slice(0, 3);
    const categoriasDropdown = categorias.slice(3);

    return (
        <Navbar className="d-flex justify-content-between align-items-center w-100" style={{ backgroundColor: '#191000' }} dark expand="md">
            <NavbarBrand href="/">
                <img src={process.env.PUBLIC_URL + '/images/logo2.png'} alt="Logo" style={{ height: '60px' }} />
            </NavbarBrand>

            {/* Toggler para menú en móviles */}
            <div className="d-flex d-md-none">
                <NavbarToggler onClick={toggleNavbar} />
                <Button color="warning" onClick={toggleModalCarrito} className="ms-2">
                    <FaShoppingCart size={20} /> {carrito.reduce((total, item) => total + item.cantidad, 0)}
                </Button>
                <Button color="secondary" onClick={toggleModalPedidos} className="ms-2"><FaBoxOpen size={20} /></Button>
            </div>

            <Collapse isOpen={isOpen} navbar>
                <Nav className="me-auto" navbar>
                    <NavItem className="mx-2">
                        <NavLink href="#" style={{ color: '#f2dcb8' }} ><strong>HOME</strong></NavLink>
                    </NavItem>


                    <NavItem className="mx-2 d-md-none">
                        <NavLink href="#" className="categories-button" onClick={toggleCategories} style={{ color: '#f2dcb8' }}>
                            <strong>CATEGORIES ▼</strong>
                        </NavLink>
                        <Collapse isOpen={isCategoriesOpen} navbar>
                            <Nav className="ml-auto" navbar>
                                {categorias.map((categoria, index) => (
                                    <NavItem key={index} className="mx-2">
                                        <NavLink href="#" onClick={() => seleccionarCategoria(categoria)} style={{ color: '#efe5d5', borderBottom: "1px solid #efe5d5" }}>
                                            {categoria}
                                        </NavLink>
                                    </NavItem>
                                ))}
                            </Nav>
                        </Collapse>
                    </NavItem>

                    {categoriasVisibles.map((categoria, index) => (
                        <NavItem key={index} className="mx-2 d-none d-md-block">
                            <NavLink href="#" onClick={() => seleccionarCategoria(categoria)} style={{ color: '#f2dcb8' }}>
                                <strong>{categoria}</strong>
                            </NavLink>
                        </NavItem>
                    ))}

                    {categoriasDropdown.length > 0 && (
                        <Dropdown nav isOpen={dropdownOpen} toggle={toggleDropdown} className="d-none d-md-block">
                            <DropdownToggle nav caret style={{ color: '#f2dcb8' }}>
                                MORE CATEGORIES
                            </DropdownToggle>
                            <DropdownMenu style={{ backgroundColor: '#191000' }}>
                                {categoriasDropdown.map((categoria, index) => (
                                    <DropdownItem key={index} href="#" onClick={() => seleccionarCategoria(categoria)} style={{ color: '#f2dcb8' }}>
                                        <strong>{categoria}</strong>
                                    </DropdownItem>
                                ))}
                            </DropdownMenu>
                        </Dropdown>
                    )}

                    <NavItem className="mx-2">
                        <NavLink href="#" style={{ color: '#f2dcb8' }}><strong>ABOUT</strong></NavLink>
                    </NavItem>
                    <NavItem className="mx-2">
                        <NavLink href="#" style={{ color: '#f2dcb8' }} onClick={() => window.location.reload()}><FaUser size={15} /> Log out</NavLink>
                    </NavItem>
                </Nav>
            </Collapse>

            {/* Carrito en modo escritorio */}
            <div className="d-none d-md-block">
                <Button color="warning" onClick={toggleModalCarrito}>
                    <FaShoppingCart size={20} /> {carrito.length}
                </Button>
                <Button color="secondary" onClick={toggleModalPedidos} className="ms-2"><FaBoxOpen size={20} /></Button>
            </div>

        </Navbar>
    );
};

export default Header;

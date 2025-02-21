import React, { useState } from 'react';
import { Navbar, NavbarBrand, Nav, NavItem, NavLink, Collapse, NavbarToggler, DropdownToggle, DropdownMenu, DropdownItem, Dropdown, Button } from 'reactstrap';
import { FaShoppingCart } from 'react-icons/fa';

const Header = ({ isOpen, toggleNavbar, productos, seleccionarCategoria, carrito, toggleModal }) => {
    const [isCategoriesOpen, setIsCategoriesOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);

    const categorias = [...new Set(productos.map((producto) => producto.categoria.toUpperCase()))];

    const toggleCategories = () => setIsCategoriesOpen(!isCategoriesOpen);
    const toggleDropdown = () => setDropdownOpen(!dropdownOpen);

    const categoriasVisibles = categorias.slice(0, 3);
    const categoriasDropdown = categorias.slice(3);

    return (
        <Navbar style={{ backgroundColor: '#191000' }} dark expand="md">
            <NavbarBrand href="/">
                <img src={process.env.PUBLIC_URL + '/images/logo2.png'} alt="Logo" style={{ height: '60px' }} />
            </NavbarBrand>
            <NavbarToggler onClick={toggleNavbar} />
            <Collapse isOpen={isOpen} navbar>
                {/* Nav principal con categorías alineadas a la izquierda */}
                <Nav className="me-auto" navbar>
                    {/* Home y About */}
                    <NavItem className="mx-2">
                        <NavLink href="#" style={{ color: '#f2dcb8' }}><strong>HOME</strong></NavLink>
                    </NavItem>
                    <NavItem className="mx-2">
                        <NavLink href="#" style={{ color: '#f2dcb8' }}><strong>ABOUT</strong></NavLink>
                    </NavItem>

                    {/* Categorías en móviles */}
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

                    {/* Categorías visibles en escritorio */}
                    {categoriasVisibles.map((categoria, index) => (
                        <NavItem key={index} className="mx-2 d-none d-md-block">
                            <NavLink href="#" onClick={() => seleccionarCategoria(categoria)} style={{ color: '#f2dcb8' }}>
                                <strong>{categoria}</strong>
                            </NavLink>
                        </NavItem>
                    ))}

                    {/* Dropdown para más categorías */}
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
                </Nav>

                {/* 🔹 Nuevo Nav solo para el carrito, alineado a la derecha */}
                <Nav className="ms-auto" navbar>
                    <NavItem className="mx-3">
                        <Button color="warning" onClick={toggleModal}>
                            <FaShoppingCart size={20} /> {carrito.length}
                        </Button>
                    </NavItem>
                </Nav>
            </Collapse>
        </Navbar>
    );
};

export default Header;

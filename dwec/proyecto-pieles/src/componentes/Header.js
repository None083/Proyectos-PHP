import React, { useState, useEffect } from 'react';
import { Navbar, NavbarBrand, Nav, NavItem, NavLink, Collapse, NavbarToggler, DropdownToggle, DropdownMenu, DropdownItem, Dropdown, Button } from 'reactstrap';
import { FaBoxOpen, FaShoppingCart, FaUser, FaSignOutAlt } from 'react-icons/fa';

const Header = ({ isOpen, toggleNavbar, productos, seleccionarCategoria, carrito, toggleModalCarrito, toggleModalPedidos, usuario }) => {
    const [isCategoriesOpen, setIsCategoriesOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const [userMenuOpen, setUserMenuOpen] = useState(false);

    const categorias = [...new Set(productos.map((producto) => producto.categoria.toUpperCase()))];

    const toggleCategories = () => setIsCategoriesOpen(!isCategoriesOpen);
    const toggleDropdown = () => setDropdownOpen(!dropdownOpen);
    const toggleUserMenu = () => { setUserMenuOpen(!userMenuOpen); };

    const categoriasVisibles = categorias.slice(0, 3);
    const categoriasDropdown = categorias.slice(3);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (userMenuOpen && !event.target.closest('.menu-container')) {
                setUserMenuOpen(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [userMenuOpen]);

    const handleMenuOptionClick = (callback) => {
        callback();
        setUserMenuOpen(false);
    };

    return (
        <Navbar className="d-flex justify-content-between align-items-center w-100" style={{ backgroundColor: '#191000' }} dark expand="md">
            <NavbarBrand href="/">
                <img src={process.env.PUBLIC_URL + '/images/logo2.png'} alt="Logo" style={{ height: '60px' }} />
            </NavbarBrand>

            <div className="d-flex d-md-none">
                <NavbarToggler onClick={toggleNavbar} />
                <div className="position-relative">
                    <Button color="success" onClick={toggleUserMenu} className="d-flex flex-row justify-content-center align-items-center ms-2 h-100">
                        <FaUser className='me-1' size={13} /> {usuario.nombre}
                    </Button>

                    {/* Menú manual sin DropdownMenu */}
                    {userMenuOpen && (
                        <div className="position-absolute bg-light text-light p-2 rounded shadow mt-1 menu-container"
                            style={{ right: 0, minWidth: "150px", zIndex: 9999 }}>
                            <button className="btn btn-light w-80 text-start" onClick={() => handleMenuOptionClick(toggleModalPedidos)}>
                                My Orders <FaBoxOpen className='mx-1' size={15} />
                            </button>
                            <hr className="text-dark" />
                            <a href="/logout" className="btn btn-light w-80 text-start">
                                Logout <FaSignOutAlt className='mx-1' size={15} />
                            </a>
                        </div>
                    )}

                </div>
                <Button color="warning" onClick={toggleModalCarrito} className="d-flex flex-row justify-content-center align-items-center ms-2">
                    <FaShoppingCart className='me-1' size={20} /> {carrito.reduce((total, item) => total + item.cantidad, 0)}
                </Button>
            </div>

            <Collapse isOpen={isOpen} navbar>
                <Nav className="me-auto" navbar>
                    <NavItem className="mx-2">
                        <NavLink href="#" style={{ color: '#f2dcb8' }}><strong>HOME</strong></NavLink>
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
                </Nav>
            </Collapse>

            <div className="d-none d-md-flex flex-row flex-nowrap">
                <div className="position-relative">
                    <Button color="success" onClick={toggleUserMenu} className="d-flex flex-row justify-content-center align-items-center ms-2 h-100">
                        <FaUser className='me-1' size={13} /> {usuario.nombre}
                    </Button>

                    {/* Menú manual sin DropdownMenu */}
                    {userMenuOpen && (
                        <div className="position-absolute bg-light text-light p-2 rounded shadow mt-1 menu-container"
                            style={{ right: 0, minWidth: "150px", zIndex: 9999 }}>
                            <button className="btn btn-light w-80 text-start" onClick={() => handleMenuOptionClick(toggleModalPedidos)}>
                                My Orders <FaBoxOpen className='mx-1' size={15} />
                            </button>
                            <hr className="text-dark" />
                            <a href="/logout" className="btn btn-light w-80 text-start">
                                Logout <FaSignOutAlt className='mx-1' size={15} />
                            </a>
                        </div>
                    )}

                </div>
                <Button color="warning" onClick={toggleModalCarrito} className="d-flex flex-row justify-content-center align-items-center ms-2">
                    <FaShoppingCart className='me-1' size={20} /> {carrito.reduce((total, item) => total + item.cantidad, 0)}
                </Button>
            </div>
        </Navbar>
    );
};

export default Header;
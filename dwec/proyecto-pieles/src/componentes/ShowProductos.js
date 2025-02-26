import React from 'react';
import Producto from './Producto';

function ShowProductos({ lista, agregar, categoria }) {
    let txtH1 = '';
    if (categoria) {
        txtH1 = categoria;
    } else {
        txtH1 = "ALL OUR PRODUCTS";
    }
    return (
        <div className="row m-2 mt-4">
            <h1 style={{ color: "#191000", textAlign: 'left', borderBottom: "1px solid #191000", paddingBottom: "0.5rem", marginBottom: '1rem', fontSize: '27px' }}>{txtH1}</h1>
            {lista.map((e, index) => (
                <div key={index} className="col-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                    <Producto
                        id={e.id}
                        img={e.imagen_url}
                        nombre={e.nombre}
                        texto={e.descripcion}
                        precio={e.precio}
                        clicar={agregar}
                    />
                </div>
            ))}
        </div>
    );
}

export default ShowProductos;

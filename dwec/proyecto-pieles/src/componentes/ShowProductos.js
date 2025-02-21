import React from 'react';
import Producto from './Producto';

function ShowProductos({ lista, modificar }) {
    return (
        <div className="row m-2 mt-4">
            {lista.map((e, index) => (
                <div key={index} className="col-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                    <Producto
                        id={e.id}
                        img={e.imagen_url}
                        nombre={e.nombre}
                        texto={e.descripcion}
                        precio={e.precio}
                        clicar={modificar}
                    />
                </div>
            ))}
        </div>
    );
}

export default ShowProductos;

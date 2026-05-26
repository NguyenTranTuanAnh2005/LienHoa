import React from "react";

export default function DoctorCard({ img, name, title }) {
    return (
        <div className="service-card">
            <img src={img} alt={name} className="doctor-img" />
            <h3 className="doctor-name">{name}</h3>
            <p className="doctor-title">{title}</p>
        </div>
    );
}
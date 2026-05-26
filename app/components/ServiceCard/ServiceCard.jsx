import React from "react";
import "./ServiceCard.css"; // Định kiểu đồng bộ

function ServiceCard({ icon, title, description, buttonText, onButtonClick }) {
    return (
        <div className="service-card">
            <div className="icon">{icon}</div>
            <h3 className="title">{title}</h3>
            <p className="desc">{description}</p>
            <button className="detail-btn" onClick={onButtonClick}>{buttonText}</button>
        </div>
    );
}

export default ServiceCard;
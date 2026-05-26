import React from "react";
import "./DoctorTeam.css";
import DoctorCard from "./DoctorCard";

const doctorData = [
    {
        img: "/images/doctor1.jpg",
        name: "BS. Nguyễn Văn A",
        title: "Chuyên khoa Nội tổng quát - 15 năm kinh nghiệm",
    },
];

export default function DoctorTeam() {
    return (
        <section className="featured-section">
            <h2 className="section-title">Đội Ngũ Bác Sĩ</h2>

            <div className="doctor-cards">
                {doctorData.map((item, idx) => (
                    <DoctorCard key={idx} {...item} />
                ))}
            </div>
        </section>
    );
}
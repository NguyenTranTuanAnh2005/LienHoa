import ServiceCard from "./ServiceCard";
const chuyenKhoaData = [
    { icon: "🩺", title: "Tim mạch", description: "Chăm sóc toàn diện về tim mạch.", buttonText: "Tìm hiểu thêm" },
    { icon: "👁️", title: "Mắt", description: "Phẫu thuật và điều trị các bệnh lý về mắt.", buttonText: "Tìm hiểu thêm" },
    // ...
];

export default function ChuyenKhoaMuiNhon() {
    return (
        <div className="chuyenkhoa-grid">
            {chuyenKhoaData.map((item, idx) =>
                <ServiceCard key={idx} {...item} onButtonClick={() => { /* Điều hướng */ }} />
            )}
        </div>
    );
}
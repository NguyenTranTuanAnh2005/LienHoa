import ServiceCard from "./ServiceCard";
const goiKhamData = [
    { icon: "🎁", title: "Gói kiểm tra tổng quát", description: "Giá ưu đãi cho tháng này.", buttonText: "Xem chi tiết" },
    { icon: "🧬", title: "Gói khám ung thư sớm", description: "Tầm soát ung thư với chi phí tiết kiệm.", buttonText: "Xem chi tiết" },
    // ...
];

export default function GoiKhamUuDai() {
    return (
        <div className="goikham-grid">
            {goiKhamData.map((item, idx) =>
                <ServiceCard key={idx} {...item} onButtonClick={() => { /* Điều hướng */ }} />
            )}
        </div>
    );
}
/**
 * FILE: script.js
 * Quản lý các tương tác người dùng, kiểm tra dữ liệu Form và Chatbot AI.
 */

document.addEventListener("DOMContentLoaded", function () {

    // --- PHẦN 1: KIỂM TRA FORM ĐẶT LỊCH ---
    const bookingForm = document.querySelector("form[action*='booking/store']");

    if (bookingForm) {
        bookingForm.addEventListener("submit", function (event) {
            let isValid = true;
            let errorFields = [];

            const patientNameInput = document.getElementById("patient_name");
            const phoneInput = document.getElementById("phone");
            const appointmentDateInput = document.getElementById("appointment_date");

            if (patientNameInput && patientNameInput.value.trim() === "") {
                isValid = false;
                errorFields.push("Họ và tên bệnh nhân");
                patientNameInput.style.borderColor = "red";
            } else if (patientNameInput) {
                patientNameInput.style.borderColor = "#dce1e6";
            }

            if (phoneInput && phoneInput.value.trim() === "") {
                isValid = false;
                errorFields.push("Số điện thoại liên hệ");
                phoneInput.style.borderColor = "red";
            } else if (phoneInput) {
                phoneInput.style.borderColor = "#dce1e6";
            }

            if (appointmentDateInput && appointmentDateInput.value.trim() === "") {
                isValid = false;
                errorFields.push("Ngày, giờ khám dự kiến");
                appointmentDateInput.style.borderColor = "red";
            } else if (appointmentDateInput) {
                appointmentDateInput.style.borderColor = "#dce1e6";
            }

            if (!isValid) {
                event.preventDefault();
                let errorMessage = "CẢNH BÁO: Vui lòng điền đầy đủ các thông tin sau:\n";
                errorFields.forEach(field => {
                    errorMessage += ` - ${field}\n`;
                });
                alert(errorMessage);
            }
        });
    }


});
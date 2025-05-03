import axios from "axios";
import validationMessages from "@/Constants/validationMessages";

export const validateUsername = (form) => {
    if (!form.username) {
        form.errors.username = validationMessages.common.required;
    } else if (form.username.length > 50) {
        form.errors.username = validationMessages.auth.username;
    } else {
        delete form.errors.username;
    }
};

export const checkEmailUniqueness = async (form, userId = null) => {
    if (form.email) {
        try {
            const response = await axios.get(route("admin.user.checkEmail"), {
                params: {
                    email: form.email,
                    id: userId, // 編集時は自身のIDを無視
                },
            });
            if (response.data.exists) {
                form.errors.email = validationMessages.common.emailUnique;
            } else {
                delete form.errors.email;
            }
        } catch (error) {
            console.error("Error checking email uniqueness:", error);
        }
    }
};

export const validateEmail = async (form, userId = null) => {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!form.email) {
        form.errors.email = validationMessages.common.required;
    } else if (!emailPattern.test(form.email)) {
        form.errors.email = validationMessages.common.email;
    } else {
        delete form.errors.email;

        // メールアドレスの形式が正しい場合のみユニークチェックを実行
        await checkEmailUniqueness(form, userId);
    }
};

export const validatePassword = (form) => {
    const passwordPattern = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;
    if (!form.password) {
        form.errors.password = validationMessages.common.required;
    } else if (form.password.length < 8) {
        form.errors.password = validationMessages.auth.password;
    } else if (!passwordPattern.test(form.password)) {
        form.errors.password =
            "パスワードは8文字以上で、半角英数字を含めて入力してください。";
    } else {
        delete form.errors.password;
    }
};

export const validatePasswordConfirmation = (form) => {
    if (!form.password_confirmation) {
        form.errors.password_confirmation = validationMessages.common.required;
    } else if (form.password !== form.password_confirmation) {
        form.errors.password_confirmation =
            validationMessages.auth.passwordConfirmation;
    } else {
        delete form.errors.password_confirmation;
    }
};

export const validateAllFields = (form) => {
    validateUsername(form);
    validateEmail(form);
    validatePassword(form);
    validatePasswordConfirmation(form);
};

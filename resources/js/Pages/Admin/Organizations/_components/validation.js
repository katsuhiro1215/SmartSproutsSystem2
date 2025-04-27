import axios from "axios";
import validationMessages from "@/Constants/validationMessages";

// 組織タイプのバリデーション 必須 / 個人 or 法人
export const validateType = (form) => {
    if (!form.type) {
        form.errors.type = validationMessages.common.required;
    } else if (!["個人", "法人"].includes(form.type)) {
        form.errors.type = validationMessages.organization.type;
    } else {
        delete form.errors.type;
    }
};

// 組織名のバリデーション 必須 / 50文字以内
export const validateName = (form) => {
    if (!form.name) {
        form.errors.name = validationMessages.common.required;
    } else if (form.name.length > 50) {
        form.errors.name = validationMessages.organization.name;
    } else {
        delete form.errors.name;
    }
};

// 組織内容のバリデーション 必須 / 1000文字以内
export const validateDescription = (form) => {
    if (!form.description) {
        form.errors.description = validationMessages.common.required;
    } else if (form.description.length > 1000) {
        form.errors.description = validationMessages.organization.description;
    } else {
        delete form.errors.description;
    }
};

const checkEmailUniqueness = async (form, organizationId = null) => {
    if (form.email) {
        try {
            const response = await axios.get(
                route("admin.organization.checkEmail"),
                {
                    params: { email: form.email },
                    id: organizationId, // 編集時は自身のIDを無視
                }
            );
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

export const validateEmail = async (form, organizationId = null) => {
    const emailPattern = /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (!form.email) {
        form.errors.email = validationMessages.common.required;
    } else if (!emailPattern.test(form.email)) {
        form.errors.email = validationMessages.common.email;
    } else {
        delete form.errors.email;

        // メールアドレスの形式が正しい場合のみユニークチェックを実行
        await checkEmailUniqueness(form, organizationId);
    }
};

// 郵便番号のバリデーション 必須 / 7桁の数字
export const validatePostalcode = (form) => {
    if (!form.postalcode) {
        form.errors.postalcode = validationMessages.common.required;
    } else if (!/^\d{7}$/.test(form.postalcode)) {
        form.errors.postalcode = validationMessages.common.postalcode;
    } else {
        delete form.errors.postalcode;
    }
};

// Prefecture(都道府県名)のバリデーション 必須 / 10文字以内
export const validatePrefecture = (form) => {
    if (!form.prefecture) {
        form.errors.prefecture = validationMessages.common.required;
    } else if (form.prefecture.length > 10) {
        form.errors.prefecture = validationMessages.common.prefecture;
    } else {
        delete form.errors.prefecture;
    }
};

// City(市区町村名)のバリデーション 必須 / 30文字以内
export const validateCity = (form) => {
    if (!form.city) {
        form.errors.city = validationMessages.common.required;
    } else if (form.city.length > 30) {
        form.errors.city = validationMessages.common.city;
    } else {
        delete form.errors.city;
    }
};
// Address1(地域名)のバリデーション 必須 / 50文字以内
export const validateAddress1 = (form) => {
    if (!form.address1) {
        form.errors.address1 = validationMessages.common.required;
    } else if (form.address1.length > 50) {
        form.errors.address1 = validationMessages.common.address1;
    } else {
        delete form.errors.address1;
    }
};
// Address2(建物名)のバリデーション 必須 / 100文字以内
export const validateAddress2 = (form) => {
    if (!form.address2) {
        form.errors.address2 = validationMessages.common.required;
    } else if (form.address2.length > 100) {
        form.errors.address2 = validationMessages.common.address2;
    } else {
        delete form.errors.address2;
    }
};

// 電話番号のバリデーション 必須 / 数字のみ / 10桁または11桁
export const validatePhoneNumber = (form) => {
    if (!form.phone_number) {
        form.errors.phone_number = validationMessages.common.required;
    } else if (!/^\d+$/.test(form.phone_number)) {
        form.errors.phone_number = validationMessages.common.phone_number;
    } else if (
        form.phone_number.length !== 10 &&
        form.phone_number.length !== 11
    ) {
        form.errors.phone_number =
            validationMessages.common.phone_number_length;
    } else {
        delete form.errors.phone_number;
    }
};

// Fav番号のバリデーション 数字のみ / 10桁または11桁
export const validateFaxNumber = (form) => {
    if (form.fax_number && !/^\d+$/.test(form.fax_number)) {
        form.errors.fax_number = validationMessages.common.fax_number;
    } else if (
        form.fax_number &&
        form.fax_number.length !== 10 &&
        form.fax_number.length !== 11
    ) {
        form.errors.fax_number = validationMessages.common.fax_number_length;
    } else {
        delete form.errors.fax_number;
    }
};

// Website URLのバリデーション URL形式
export const validateWebsiteUrl = (form) => {
    if (
        form.website_url &&
        !/^(https?:\/\/)?([\w.-]+)(:[0-9]{1,5})?(\/.*)?$/.test(form.website_url)
    ) {
        form.errors.website_url = validationMessages.common.website_url;
    } else {
        delete form.errors.website_url;
    }
};

// Facebook URLのバリデーション URL形式
export const validateFacebookUrl = (form) => {
    if (
        form.facebook_url &&
        !/^(https?:\/\/)?([\w.-]+)(:[0-9]{1,5})?(\/.*)?$/.test(
            form.facebook_url
        )
    ) {
        form.errors.facebook_url = validationMessages.common.facebook_url;
    } else {
        delete form.errors.facebook_url;
    }
};

// Twitter URLのバリデーション URL形式
export const validateTwitterUrl = (form) => {
    if (
        form.twitter_url &&
        !/^(https?:\/\/)?([\w.-]+)(:[0-9]{1,5})?(\/.*)?$/.test(form.twitter_url)
    ) {
        form.errors.twitter_url = validationMessages.common.twitter_url;
    } else {
        delete form.errors.twitter_url;
    }
};

// Instagram URLのバリデーション URL形式
export const validateInstagramUrl = (form) => {
    if (
        form.instagram_url &&
        !/^(https?:\/\/)?([\w.-]+)(:[0-9]{1,5})?(\/.*)?$/.test(
            form.instagram_url
        )
    ) {
        form.errors.instagram_url = validationMessages.common.instagram_url;
    } else {
        delete form.errors.instagram_url;
    }
};

// Youtube URLのバリデーション URL形式
export const validateYoutubeUrl = (form) => {
    if (
        form.youtube_url &&
        !/^(https?:\/\/)?([\w.-]+)(:[0-9]{1,5})?(\/.*)?$/.test(form.youtube_url)
    ) {
        form.errors.youtube_url = validationMessages.common.youtube_url;
    } else {
        delete form.errors.youtube_url;
    }
};

// LINE URLのバリデーション URL形式
export const validateLineUrl = (form) => {
    if (
        form.line_url &&
        !/^(https?:\/\/)?([\w.-]+)(:[0-9]{1,5})?(\/.*)?$/.test(form.line_url)
    ) {
        form.errors.line_url = validationMessages.common.line_url;
    } else {
        delete form.errors.line_url;
    }
};

// 設立日のバリデーション 正しい日付形式（YYYY-MM-DD）
export const validateEstablishedDate = (form) => {
    if (
        form.established_date &&
        !/^\d{4}-\d{2}-\d{2}$/.test(form.established_date)
    ) {
        form.errors.established_date =
            validationMessages.common.established_date;
    } else {
        delete form.errors.established_date;
    }
};

// ステータスのバリデーション 選択必須
export const validateStatus = (form) => {
    if (form.status === null || form.status === undefined) {
        form.errors.status = validationMessages.common.required;
    } else {
        delete form.errors.status;
    }
};

export const validateAllFields = (form) => {
    validateType(form);
    validateName(form);
    validateDescription(form);
    validateEmail(form);
    validatePostalcode(form);
    validatePrefecture(form);
    validateCity(form);
    validateAddress1(form);
    validateAddress2(form);
    validatePhoneNumber(form);
    validateFaxNumber(form);
    validateWebsiteUrl(form);
    validateFacebookUrl(form);
    validateTwitterUrl(form);
    validateInstagramUrl(form);
    validateYoutubeUrl(form);
    validateLineUrl(form);
    validateEstablishedDate(form);
    validateStatus(form);
};

import validationMessages from "@/Constants/validationMessages";

// イベント名のバリデーション 必須 / 50文字以内
export const validateName = (form) => {
    if (!form.name) {
        form.errors.name = validationMessages.common.required;
    } else if (form.name.length > 50) {
        form.errors.name = validationMessages.event.name;
    } else {
        delete form.errors.name;
    }
};

// イベント内容のバリデーション 必須 / 1000文字以内
export const validateDescription = (form) => {
    if (!form.description) {
        form.errors.description = validationMessages.common.required;
    } else if (form.description.length > 1000) {
        form.errors.description = validationMessages.event.description;
    } else {
        delete form.errors.description;
    }
};

// 郵便番号のバリデーション 必須ではない / 7桁の数字
export const validatePostalcode = (form) => {
    if (!/^\d{7}$/.test(form.postalcode)) {
        form.errors.postalcode = validationMessages.common.postalcode;
    } else {
        delete form.errors.postalcode;
    }
};

// Prefecture(都道府県名)のバリデーション 必須 / 10文字以内
export const validatePrefecture = (form) => {
    if (form.prefecture.length > 10) {
        form.errors.prefecture = validationMessages.common.prefecture;
    } else {
        delete form.errors.prefecture;
    }
};

// City(市区町村名)のバリデーション 必須 / 30文字以内
export const validateCity = (form) => {
    if (form.city.length > 30) {
        form.errors.city = validationMessages.common.city;
    } else {
        delete form.errors.city;
    }
};

// Address1(地域名)のバリデーション 必須 / 50文字以内
export const validateAddress1 = (form) => {
    if (form.address1.length > 50) {
        form.errors.address1 = validationMessages.common.address1;
    } else {
        delete form.errors.address1;
    }
};

// Address2(建物名)のバリデーション 必須 / 100文字以内
export const validateAddress2 = (form) => {
    if (form.address2.length > 100) {
        form.errors.address2 = validationMessages.common.address2;
    } else {
        delete form.errors.address2;
    }
};

// 電話番号のバリデーション 必須 / 数字のみ / 10桁または11桁
export const validatePhoneNumber = (form) => {
    if (!/^\d+$/.test(form.phone_number)) {
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

// ステータスのバリデーション 選択必須
export const validateStatus = (form) => {
    if (form.status === null || form.status === undefined) {
        form.errors.status = validationMessages.common.required;
    } else {
        delete form.errors.status;
    }
};

// イベント開始日のバリデーション 必須 / 正しい日付形式（YYYY-MM-DD）
export const validateEventStartDate = (form) => {
    if (!form.event_start_date) {
        form.errors.event_start_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.event_start_date)) {
        form.errors.event_start_date =
            validationMessages.common.event_start_date;
    } else {
        delete form.errors.event_start_date;
    }
};

// イベント終了日のバリデーション 必須 / 正しい日付形式（YYYY-MM-DD）
export const validateEventEndDate = (form) => {
    if (!form.event_end_date) {
        form.errors.event_end_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.event_end_date)) {
        form.errors.event_end_date =
            validationMessages.common.event_end_date;
    } else {
        delete form.errors.event_end_date;
    }
};

// イベント申込開始日のバリデーション 必須 / 正しい日付形式（YYYY-MM-DD）
export const validateApplicationStartDate = (form) => {
    if (!form.application_start_date) {
        form.errors.application_start_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.application_start_date)) {
        form.errors.application_start_date =
            validationMessages.common.application_start_date;
    } else {
        delete form.errors.application_start_date;
    }
};

// イベント申込開始時間のバリデーション 必須 / 正しい時間形式（HH:MM）
export const validateApplicationStartTime = (form) => {
    if (!form.application_start_time) {
        form.errors.application_start_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.application_start_time)) {
        form.errors.application_start_time =
            validationMessages.common.application_start_time;
    } else {
        delete form.errors.application_start_time;
    }
};

// イベント申込終了日のバリデーション 必須 / 正しい日付形式（YYYY-MM-DD）
export const validateApplicationEndDate = (form) => {
    if (!form.application_end_date) {
        form.errors.application_end_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.application_end_date)) {
        form.errors.application_end_date =
            validationMessages.common.application_end_date;
    } else {
        delete form.errors.application_end_date;
    }
};

// イベント申込終了時間のバリデーション 必須 / 正しい時間形式（HH:MM）
export const validateApplicationEndTime = (form) => {
    if (!form.application_end_time) {
        form.errors.application_end_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.application_end_time)) {
        form.errors.application_end_time =
            validationMessages.common.application_end_time;
    } else {
        delete form.errors.application_end_time;
    }
};

export const validateAllFields = (form) => {
    validateName(form);
    validateDescription(form);
    validatePostalcode(form);
    validatePrefecture(form);
    validateCity(form);
    validateAddress1(form);
    validateAddress2(form);
    validatePhoneNumber(form);
    validateStatus(form);
    validateEventStartDate(form);
    validateEventEndDate(form);
    validateApplicationStartDate(form);
    validateApplicationStartTime(form);
    validateApplicationEndDate(form);
    validateApplicationEndTime(form);
};

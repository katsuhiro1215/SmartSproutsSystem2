import validationMessages from "@/Constants/validationMessages";

// 店舗IDのバリデーション 選択必須
export const validateStoreId = (form) => {
    if (!form.store_id) {
        form.errors.store_id = validationMessages.common.required;
    } else {
        delete form.errors.store_id;
    }
};

// 店舗の営業日 必須
export const validateBusinessDate = (form) => {
    if (!form.business_date) {
        form.errors.business_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.business_date)) {
        form.errors.business_date = validationMessages.common.business_date;
    } else {
        delete form.errors.business_date;
    }
};

// 店舗の営業開始時間 必須
export const validateStartTime = (form) => {
    if (!form.start_time) {
        form.errors.start_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.start_time)) {
        form.errors.start_time = validationMessages.common.start_time;
    } else {
        delete form.errors.start_time;
    }
};

// 店舗の営業終了時間 必須
export const validateEndTime = (form) => {
    if (!form.end_time) {
        form.errors.end_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.end_time)) {
        form.errors.end_time = validationMessages.common.end_time;
    } else {
        delete form.errors.end_time;
    }
};

// 店舗の営業曜日のバリデーション enum 月曜日から日曜日までの文字列
export const validateDayOfWeek = (form) => {
    const validDays = [
        "月曜日",
        "火曜日",
        "水曜日",
        "木曜日",
        "金曜日",
        "土曜日",
        "日曜日",
    ];

    if (!form.day_of_week) {
        form.errors.day_of_week = validationMessages.common.required;
    } else if (!validDays.includes(form.day_of_week)) {
        form.errors.day_of_week = validationMessages.common.day_of_week;
    } else {
        delete form.errors.day_of_week;
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

// 店舗のnoteのバリデーション 255文字以内
export const validateNote = (form) => {
    if (form.note && form.note.length > 255) {
        form.errors.note = validationMessages.common.note;
    } else {
        delete form.errors.note;
    }
};

export const validateAllFields = (form) => {
    validateStoreId(form);
    validateStartDate(form);
    validateStartTime(form);
    validateEndDate(form);
    validateEndTime(form);
    validateDayOfWeek(form);
    validateStatus(form);
    validateNote(form);
};

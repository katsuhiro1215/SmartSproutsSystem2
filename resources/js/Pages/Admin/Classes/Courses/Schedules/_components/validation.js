import validationMessages from "@/Constants/validationMessages";

// コースIDのバリデーション 選択必須
export const validateCourseId = (form) => {
    if (!form.course_id) {
        form.errors.course_id = validationMessages.common.required;
    } else {
        delete form.errors.course_id;
    }
};

// コースの営業日 必須
export const validateCourseDate = (form) => {
    if (!form.course_date) {
        form.errors.course_date = validationMessages.common.required;
    } else if (!/^\d{4}-\d{2}-\d{2}$/.test(form.course_date)) {
        form.errors.course_date = validationMessages.common.course_date;
    } else {
        delete form.errors.course_date;
    }
};

// コースの営業開始時間 必須
export const validateStartTime = (form) => {
    if (!form.start_time) {
        form.errors.start_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.start_time)) {
        form.errors.start_time = validationMessages.common.start_time;
    } else {
        delete form.errors.start_time;
    }
};

// コースの営業終了時間 必須
export const validateEndTime = (form) => {
    if (!form.end_time) {
        form.errors.end_time = validationMessages.common.required;
    } else if (!/^\d{2}:\d{2}$/.test(form.end_time)) {
        form.errors.end_time = validationMessages.common.end_time;
    } else {
        delete form.errors.end_time;
    }
};

// コースの営業曜日のバリデーション enum 月曜日から日曜日までの文字列
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


export const validateAllFields = (form) => {
    validateCourseId(form);
    validateCourseDate(form);
    validateStartTime(form);
    validateEndTime(form);
    validateDayOfWeek(form);
    validateStatus(form);
};

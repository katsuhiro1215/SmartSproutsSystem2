// エラー内容と解決策を定義
export default {
    // // 共通
    common: {
        required: "この項目は入力必須です。",
        start_date: "開始日は正しい日付形式（YYYY-MM-DD）で入力してください。",
        start_date_before_end_date:
            "開始日は終了日より前の日付を選択してください。",
        end_date: "終了日は正しい日付形式（YYYY-MM-DD）で入力してください。",
        end_date_after_start_date:
            "終了日は開始日より後の日付を選択してください。",
        start_time: "開始時間は正しい時間形式（HH:MM）で入力してください。",
        start_time_before_end_time:
            "開始時間は終了時間より前の時間を選択してください。",
        end_time: "終了時間は正しい時間形式（HH:MM）で入力してください。",
        end_time_after_start_time:
            "終了時間は開始時間より後の時間を選択してください。",
        business_date: "営業日は正しい日付形式（YYYY-MM-DD）で入力してください。",
        day_of_week: "曜日は月曜日から日曜日のいずれかを選択してください。",
        email: "メールアドレスの形式で入力してください。",
        emailUnique: "このメールアドレスは既に使用されています。",
        lastname: "姓は40文字以内で入力してください。",
        firstname: "名は40文字以内で入力してください。",
        lastname_kana: "姓(カナ)は50文字以内で入力してください。",
        firstname_kana: "名(カナ)は50文字以内で入力してください。",
        postalcode: "郵便番号は7桁の数字で入力してください。",
        prefecture: "都道府県名は10文字以内で入力してください。",
        cist: "市区町村名は30文字以内で入力してください。",
        address1: "町名・番地は50文字以内で入力してください。",
        address2: "建物名などは100文字以内で入力してください。",
        phone_number: "電話番号は数字で入力してください。",
        phone_number_length:
            "電話番号は10桁または11桁の数字で入力してください。",
        mobile_number: "携帯電話番号は数字で入力してください。",
        mobile_number_length:
            "携帯電話番号は10桁または11桁の数字で入力してください。",
        fax_number: "FAX番号は数字で入力してください。",
        fax_number_length: "FAX番号は10桁または11桁の数字で入力してください。",
        company_name: "会社名は50文字以内で入力してください。",
        company_phone_number:
            "会社電話番号は数字で入力してください。",
        company_phone_number_length:
            "会社電話番号は10桁または11桁の数字で入力してください。",
        established_date:
            "設立日は正しい日付形式（YYYY-MM-DD）で入力してください。",
        website_url: "ウェブサイトURLは正しい形式で入力してください。",
        facebook_url: "Facebook URLは正しい形式で入力してください。",
        twitter_url: "Twitter URLは正しい形式で入力してください。",
        instagram_url: "Instagram URLは正しい形式で入力してください。",
        youtube_url: "Youtube URLは正しい形式で入力してください。",
        line_url: "LINE URLは正しい形式で入力してください。",
    },
    // 認証関連 admin & user 共通
    auth: {
        username: "ユーザー名は50文字以内で入力してください。",
        password: "パスワードは8文字以上で入力してください。",
        passwordConfirmation: "パスワードが一致しません。",
    },
    organization: {
        type: "組織タイプは個人または法人のいずれかを選択してください。",
        name: "組織名は40文字以内で入力してください。",
        description: "組織の説明は1000文字以内で入力してください。",
    },
};
<?php

/**
 * Actors model config
 */

return array(

    'title' => 'Log Maxpay',

    'single' => 'log',

    'model' => 'LogMaxpay',

    /**
     * The display columns
     */
    'columns' => array(
        'id',
        'txn_card_id'=> array(
            'title' => 'ID Giao dịch'
        ),
        'card_type' => array(
            'title' => 'Loại thẻ',
            'select' => "card_type",
        ),
        'pin' => array(
            'title' => 'Pin',
            'select' => "pin",
        ),
        'seri' => array(
            'title' => 'Seri',
            'select' => "seri",
        ),
        'card_amount'=> array(
            'title' => 'Mệnh giá'
        ),
        'response_code' => array(
            'title'=>'Mã lỗi',
        ),
        'response_message' => array(
            'title' => 'Thông báo'
        ),
        'created_at' => array(
            'title'=>'Thời gian giao dịch',
            'select'=>'created_at'
        ),
    ),

    /**
     * The filter set
     */
    'filters' => array(
        'txn_card_id'=> array(
            'title' => 'ID Giao dịch'
        ),
        'card_type' => array(
            'title' => 'Loại thẻ',
        ),
        'pin' => array(
            'title' => 'Pin',
        ),
        'seri' => array(
            'title' => 'Seri',
        ),
        'response_code' => array(
            'title' => 'Mã lỗi',
        ),
        'created_at' => array(
            'title' => 'Thời gian GD',
            'type' => 'date',
        ),
    ),

    /**
     * The editable fields
     */
    'edit_fields' => array(
        'id'
    ),
);
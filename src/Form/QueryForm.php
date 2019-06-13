<?php
namespace Nielsen\SelectRunner\Form;

use Ray\WebFormModule\AbstractForm;

class QueryForm extends AbstractForm
{
    const BAN_WORDS = [
        'INSERT', 'UPDATE', 'CREATE', 'DELETE', 'DROP', 'TRUNCATE', 'ALTER', 'SET',
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('query', 'textarea')
            ->setAttribs([
                'id' => 'queryInput',
                'rows' => 12,
                'class' => 'form-control',
            ]);
        $this->filter->validate('query')->isNotBlank();
        // 禁止ワードのチェック
        $this->filter->validate('query')->is('callback', function ($subject, $field) {
            foreach (self::BAN_WORDS as $item) {
                if (stripos($subject->$field, $item) !== false) {
                    return false;
                }
            }

            return true;
        });
        $this->filter->useFieldMessage('query', 'Please input select statement!');
    }
}

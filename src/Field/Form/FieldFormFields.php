<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Field\Form\Command\GetConfigFields;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class FieldFormFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldFormFields
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param FieldFormBuilder $builder
     */
    public function handle(FieldFormBuilder $builder)
    {
        $id        = $builder->getFormEntryId();
        $namespace = $builder->getFieldNamespace();

        $builder->setFields(
            [
                'name' => [
                    'label'        => 'streams::field.name.name',
                    'instructions' => 'streams::field.name.instructions',
                    'type'         => 'anomaly.field_type.text',
                    'required'     => true
                ],
                'slug' => [
                    'label'        => 'streams::field.slug.name',
                    'instructions' => 'streams::field.slug.instructions',
                    'type'         => 'anomaly.field_type.slug',
                    'unique'       => 'unique:streams_fields,slug,' . $id . ',namespace,namespace,' . $namespace,
                    'required'     => true,
                    'disabled'     => 'edit',
                    'config'       => [
                        'slugify' => 'name',
                        'type'    => '_'
                    ]
                ]
            ]
        );

        if (($type = $builder->getFormEntry()->getType()) || ($type = $builder->getFieldType())) {
            foreach ($config = $this->dispatch(new GetConfigFields($type)) as $field) {
                $builder->addField($field);
            }
        }
    }
}

<?php

namespace Modules\Registration\Forms;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Forms\FormAbstract;
use Modules\Registration\Entities\Faculty;
use Modules\Registration\Http\Requests\FacultyRequest;

class FacultyForm extends FormAbstract
{
    public function buildForm()
    {
        $facultyId = 0;
        $sessions = [];

        if ($this->getModel()) {
            $facultyId = $this->getModel()->id;
            $sessions = $this->getModel()->sessions;
        }

        $this
            ->setupModel(new Faculty)
            ->setValidatorClass(FacultyRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => 'Fullname',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => 'Please enter Fullname'
                ],
            ])
            ->add('title', 'text', [
                'label'      => 'Title',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => 'Please enter Title'
                ],
            ])
            ->add("bio", "editor", [
                "label" => 'Bio',
                "label_attr" => ["class" => "control-label tinymce required"],
                "attr" => [
                    "rows" => 4,
                    "class" => "tinymce editor-tinymce form-control",
                    "placeholder" => __("base::form.description_placeholder")
                ],
            ])
            ->add("sections", "editor", [
                "label" => 'Sections',
                "label_attr" => ["class" => "control-label tinymce required"],
                "attr" => [
                    "rows" => 4,
                    "class" => "tinymce editor-tinymce form-control",
                    "placeholder" => __("base::form.description_placeholder")
                ],
            ])
            ->add("country", "select", [
                "label" => 'Country',
                "label_attr" => ["class" => "control-label"],
                "attr" => [
                    "class" => "form-control select2",
                ],
                "choices" => allCountries(),
            ])
            ->add("avatar", "singleImage", [
                "label" => 'Avatar',
                "label_attr" => ["class" => "control-label"],
            ])
            ->setBreakFieldPoint('country')
            ->addMetaBoxes([
                "faculty-detail" => [
                    "title" => 'Sessions',
                    "content" => view('registration::faculty.form.partials.detail', compact('facultyId', 'sessions')),
                ]
            ]);
    }
}

<?php
namespace Modules\Acl\Forms;

use Modules\Base\Forms\FormAbstract;
use App\User;
use Modules\Acl\Http\Requests\UserRequest;

class ProfileForm extends FormAbstract
{
  public function __construct()
  {
    parent::__construct();
  }

  public function buildForm()
  {
    if ($this->getModel()) {
     
    }
    $this->setupModel(new User())
      ->setFormOption('template', 'base::forms.form-no-wrap')
      ->setFormOption('id', 'profile-form')
      ->setValidatorClass(UserRequest::class)
      ->withCustomFields()
      ->add("rowOpen1", "html", [
        "html" => '<div class="row">',
      ])
      ->add("name", "text", [
        "label" => __("acl::form.title"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("acl::form.placeholder.name"),
        ],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("email", "text", [
        "label" => __("acl::form.email"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("acl::form.placeholder.email"),
        ],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("rowClose1", "html", [
        "html" => "</div>",
      ])
      ->add("rowOpen2", "html", [
        "html" => '<div class="row">',
      ])
      ->add("first_name", "text", [
        "label" => __("acl::form.first_name"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("acl::form.placeholder.first_name"),
        ],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("last_name", "text", [
        "label" => __("acl::form.last_name"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("acl::form.placeholder.last_name"),
        ],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("rowClose2", "html", [
        "html" => "</div>",
      ])
      ->add("rowOpen3", "html", [
        "html" => '<div class="row">',
      ])
      ->add("phone", "text", [
        "label" => __("acl::form.phone"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("acl::form.placeholder.phone"),
        ],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("gender", "select", [
        "label" => __("acl::form.gender"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "class" => "form-control",
          "placeholder" => __("acl::form.placeholder.gender"),
        ],
        "choices" => ["1" => "Nam", "2" => "Nữ"],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("rowClose3", "html", [
        "html" => "</div>",
      ])
      ->add("rowOpen4", "html", [
        "html" => '<div class="row">',
      ])
      ->add("skype", "text", [
        "label" => __("acl::form.skype"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("acl::form.placeholder.skype"),
        ],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("facebook", "text", [
        "label" => __("acl::form.facebook"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "placeholder" => __("acl::form.placeholder.facebook"),
        ],
        "wrapper" => [
          "class" =>
            $this->formHelper->getConfig("defaults.wrapper_class") .
            " col-md-6",
        ],
      ])
      ->add("rowClose4", "html", [
        "html" => "</div>",
      ])
      ->add("interest", "editor", [
        "label" => __("acl::form.interest"),
        "label_attr" => ["class" => "control-label required"],
        "attr" => [
          "rows" => 4,
          "placeholder" => __("acl::form.placeholder.interest"),
        ],
      ])
      ->setActionButtons(view('acl::button.profile.actions')->render());;
  }
}

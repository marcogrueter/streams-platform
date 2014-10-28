<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Ui;
use Anomaly\Streams\Platform\Entry\EntryInterface;

/**
 * Class FormUi
 *
 * This class is responsible for rendering entry
 * forms and handling their primary features.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormUi extends Ui
{

    /**
     * The entry, id or null.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * @var array
     */
    protected $skips = [];

    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @var array
     */
    protected $actions = [];

    /**
     * @var string
     */
    protected $view = 'html/form';

    /**
     * Make the UI response.
     *
     * @return \Illuminate\View\View
     */
    public function make($entry = null)
    {
        $this->entry = $entry;

        return parent::make();
    }


    /**
     * Trigger logic to build content.
     *
     * @return null|string
     */
    protected function trigger()
    {
        $this->fire('trigger');

        $form = $this->newFormService();

        $sections = $form->sections();
        $actions  = $form->actions();

        $data = compact('sections', 'actions');

        return view($this->view, $data);
    }

    /**
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param array $actions
     * return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param array $sections
     * return $this
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param array $skips
     * return $this
     */
    public function setSkips(array $skips)
    {
        $this->skips = $skips;

        return $this;
    }

    /**
     * @return array
     */
    public function getSkips()
    {
        return $this->skips;
    }

    /**
     * @param string $view
     * return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return FormService
     */
    protected function newFormService()
    {
        return new FormService($this);
    }

    /**
     * @return FormRepository
     */
    protected function newRepository()
    {
        return new FormRepository($this, $this->model);
    }

    /**
     * @return FormRequest
     */
    protected function newFormRequest()
    {
        return new FormRequest($this);
    }

    protected function onTrigger()
    {
        if (!$this->entry instanceof EntryInterface) {

            $this->entry = $this->newRepository()->get();

        }

        if (app('request')->is('post')) {



        }
    }
}
 
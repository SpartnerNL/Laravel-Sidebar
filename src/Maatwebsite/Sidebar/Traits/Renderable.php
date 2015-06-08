<?php

namespace Maatwebsite\Sidebar\Traits;

trait Renderable
{
    /**
     * Render the item
     */
    public function render()
    {
        if ($this->isAuthorized()) {
            return $this->factory->make($this->getView(), [
                $this->getRenderType() => $this
            ])->render();
        }
    }

    /**
     * Get the view
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param $view
     *
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the render type
     * @return mixed
     */
    public function getRenderType()
    {
        return $this->renderType;
    }

    /**
     * Too string
     */
    public function __toString()
    {
        return $this->render();
    }
}

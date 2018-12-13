<?php namespace Anomaly\Streams\Platform\Ui\Table\Event;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;
/**
 * Class TableWasQueried
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableWasQueried
{
    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;
    /**
     * The table query.
     *
     * @var Builder
     */
    protected $query;
    /**
     * Create a new TableWasQueried instance.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function __construct(TableBuilder $builder, Builder $query)
    {
        $this->builder = $builder;
        $this->query   = $query;
    }
    /**
     * Get the query.
     *
     * @return Builder
     */
    public function getQuery()
    {
        return $this->query;
    }
    /**
     * Get the table.
     *
     * @return TableBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}

<?php
namespace CrudView\Dashboard;

use Cake\Datasource\EntityTrait;
use Cake\View\Cell;
use InvalidArgumentException;

class Dashboard
{
    use EntityTrait;

    /**
     * Constructor
     *
     * @param string $title The name of the group
     * @param int $columns Number of columns
     */
    public function __construct($title = null, $columns = 1)
    {
        if ($title === null) {
            $title = __d('CrudView', 'Dashboard');
        }

        $this->set('title', $title);
        $this->set('children', []);
        $this->set('columns', $columns);
    }

    /**
     * Returns the children from a given column
     *
     * @param int $column a column number
     * @return array
     */
    public function getColumnChildren($column)
    {
        $children = $this->get('children');
        if (isset($children[$column])) {
            return $children[$column];
        }

        return [];
    }

    /**
     * Adds a Cell to a given column
     *
     * @param Cell $module instance of Cell
     * @param int $column a column number
     * @return $this
     */
    public function addToColumn(Cell $module, $column = 1)
    {
        $children = $this->get('children');
        $children[$column][] = $module;
        $this->set('children', $children);

        return $this;
    }

    /**
     * columns property setter
     *
     * @param int $value A column count
     * @return int
     * @throws \InvalidArgumentException the column count is invalid
     */
    protected function _setColumns($value)
    {
        $columnMap = [
            1 => 12,
            2 => 6,
            3 => 4,
            4 => 3,
            6 => 2,
            12 => 1,
        ];
        if (!in_array($value, [1, 2, 3, 4, 6, 12])) {
            throw new InvalidArgumentException('Valid columns value must be one of [1, 2, 3, 4, 6, 12]');
        }

        $this->set('columnClass', sprintf('col-md-%d', $columnMap[$value]));

        return $value;
    }
}

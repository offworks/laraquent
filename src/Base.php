<?php
namespace Laraquent;

abstract class Base extends \Illuminate\Database\Eloquent\Model
{
	public function isNew()
	{
		return !$this->exists;
	}

	public function getRelationValue($key)
	{
		// If the key already exists in the relationships array, it just means the
		// relationship has already been loaded, so we'll just return it out of
		// here because there is no need to query within the relations twice.
		if ($this->relationLoaded($key)) {
			return $this->relations[$key];
		}

		// If the "attribute" exists as a method on the model, we will just assume
		// it is a relationship and will load and return results from the query
		// and hydrate the relationship's value on the "relationships" array.
		if (method_exists($this, $method = 'relate'.ucwords($key))) {
			return $this->getRelationshipFromMethod($method);
		}
	}

	/**
	 * If $attributes is given, will use the list only
	 * @param attributes
	 */
	public function toArray(array $attributes = array())
	{
		$data = parent::toArray();

		if(count($attributes) == 0)
			return $data;

		$new = array();

		foreach($attributes as $attribute)
			$new[$attribute] = $data[$attribute];

		return $new;
	}
}
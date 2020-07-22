<?php

namespace App\Providers;

use App\Interfaces\Repository\ConfigurationInterface;
use App\Rules\RequestFieldValueUnique;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ExtendValidatorServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ConfigurationInterface $configurationRepository)
    {

        /**
         * Check if given attribute value is unique in request array
         */
        Validator::extend('requestFieldValueUnique', function ($attribute, $value, $parameters, $validator) {
            $attribute = explode(".", $attribute);

            if (!isset($attribute[1]))
            {
                return false;
            }

            $requestData = request()->input();
            unset($requestData[$attribute[0]]);

            foreach($requestData as $data)
            {
                 if (array_key_exists($attribute[1], $data) && $data[$attribute[1]] === $value)
                 {
                     return false;
                 }
            }

           return true;
        }, ":attribute has to be unique within request input data array");

        /**
         * Allows to store/update by one method
         *
         * Return true if given parameter value is found in DB, else if attribute/value exists return false or if it doesn't exists true
         */
        Validator::extend('uniqueIfGivenAttrDoesntExists', function ($attribute, $value, $parameters, $validator) use ($configurationRepository) {
            $requestData = request()->input();

            $attributeNumber = explode(".", $attribute);
            $attributeNumber = isset($attributeNumber[0]) ? $attributeNumber[0]: false;

            $uniqueParameter = $parameters[0];

            $parameterAttributeValue = $attributeNumber === false ? $requestData[$uniqueParameter] : $requestData[$attributeNumber][$uniqueParameter];

            if ($parameterAttributeValue !== null && $configurationRepository->findWhere($uniqueParameter, $parameterAttributeValue)->first() !== null)
            {
                return true;

            } else {

                $attribute = explode(".", $attribute);
                $attribute = $attribute[1] ?? $attribute;

                if ($configurationRepository->findWhere($attribute, $value)->first() !== null)

                    return false;
            }

            return true;
        }, ":attribute is already in use and given check attribute is also not found.");


    }
}

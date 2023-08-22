<?php

namespace App\Support\Traits;

trait ValidationRequest
{
    public function authorize()
    {
        return true;
    }

    public function messagesAction(): array
    {
        return [];
    }

    public function messages($array = []): array
    {

        return array_merge(
            [
                'name.required'             => t_('The name field required.'),
                'name.string'               => t_('The name field must be string.'),
                'phone_number.*.required'   => t_('The phone number field required.'),
                'phone_number.*.unique'     => t_('The phone number field has already been taken.'),
                'phone_number.*.exists'     => t_('The phone number not found'),
                'phone_number.*.phone'      => t_('The phone number field field does not contain an invalid number.'),
                'email.required'            => t_('The email field required.'),
                'email.unique'              => t_('The email has already been taken.'),
                'email.email'               => t_('The email must be a valid email.'),
                'password.required'         => t_('The password field required.'),
                'password.string'           => t_('The password field must be string.'),
                'password.min:6'            => t_('The password field must not be less than 6 characters.'),
                'password.confirmed'        => t_('The password field must be confirmed.'),
                'account_type.required'     => t_('The account type field required.'),
                'account_type.in'           => t_('The account type field Not Valid Type.'),
                'country.array'             => t_('The country field required.'),
                'company_name.required_if'  => t_('The company name field is required when account type is company.'),
                'commercial_no.required_if' => t_('The commercial no field is required when account type is company.'),
                'data.array'                => t_('The data must be array.'),
                'title.array'               => t_('The title must be array.'),
                'title.*.required'          => t_('The :attribute field required.'),
                'description.array'         => t_('The description must br array.'),
                'roles.array'               => t_('The roles must be array.'),
                'level.integer'             => t_('The level must be integer.'),
                'latitude.numeric'          => t_('The latitude must be numeric.'),
                'longitude.numeric'         => t_('The longitude must be numeric.'),
                'address.max:255'           => t_('The address must less than 255 characters.'),
                'site_name.max:100'         => t_('The site_name must less than 100 characters.'),
                'site_logo.image'           => t_('The site_logo must be image.'),
                'site_favicon.image'        => t_('The site_favicon must be image.'),
                'type.required'             => t_('The type field required.'),
                'price.numeric'             => t_('The price must be numeric.'),
                'price.min:1'               => t_('The price must not be less than 1 characters.'),
                'price.max:9999999999'      => t_('The price must be less than 9999999999 characters.'),
                'images_collection.array'   => t_('The images collection must be array.'),
                'images_collection.min:1'   => t_('The images collection must be not less than 1 .'),
                'logo.image'                => t_('The logo must be image..'),
                'cover.image'               => t_('The cover must be image..'),
                'avatar.image'              => t_('The avatar must be image..'),
                'facebook_url.max:50'       => t_('The facebook url must less than 50 characters.'),
                'twitter_url.max:50'        => t_('The twitter url must less than 50 characters.'),
                'instagram_url.max:50'      => t_('The instagram url must less than 50 characters.'),
                'bank_number.max:15'        => t_('The bank_number  must less than 15 characters.'),
                'manager_number.max:15'     => t_('The manager number  must less than 15 characters.'),
                'store_number.max:15'       => t_('The store number must less than 15 characters.'),
                'employee_number.max:15'    => t_('The employee number must less than 15 characters.'),
                'area_id.required'          => t_('The area id field required.'),
                'bio.required'              => t_('The bio field required.'),
                'bio.max:50'                => t_('The bio must less than 50 characters.'),
                'location.max:200'          => t_('The location must less than 200 characters.'),
                'phone.required'            => t_('The phone field required.'),
                'store_id.required'         => t_('The store field required.'),
                'store_id.exists'           => t_('The store field must be valid store.'),

            ], $this->messagesAction());
    }
}

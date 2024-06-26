import React, {useEffect} from 'react'
import { Fragment, useState } from 'react'
import { Combobox, Transition } from '@headlessui/react'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/react/20/solid'
import axios from 'axios'

export default function CitiesInput({onCitySelect, marginTop}) {
  const [cities, setCities] = useState([]);
  const [selected, setSelected] = useState({})
  const [query, setQuery] = useState('')

  useEffect(() => {
    if (query != "") {
      axios.get(`/ajax/cities/${query}`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).then(response => {
        setCities(response.data);
      }).catch(error => console.error('Erreur lors de la récupération des données:', error));
    }
    else {
      setCities([]);
    }
  }, [query]);

  useEffect(() => {
    if (cities.length === 0) {
      setSelected({});
    }
  }, [cities])

  useEffect(() => {
    onCitySelect(selected);
  }, [selected]);

  const filteredCities =
    query === '' || cities.length === 0
      ? cities
      : cities.filter((city) => {
          if (/\d/.test(query)) {
            const Name = query.replace(/\d/g, '').trim();
            const ZipCode = query.replace(/\D/g, '').trim();
            city.name
              .toLowerCase()
              .replace(/\s+/g, '')
              .includes(Name.toLowerCase().replace(/\s+/g, ''));
            return city.zip_code.toString()
              .includes(ZipCode);
          } else {
            return city.name
              .toLowerCase()
              .replace(/\s+/g, '')
              .includes(query.toLowerCase().replace(/\s+/g, '').trim())
          }
        }
    );
    
  return (
    <div className={`top-16 w-72 ${marginTop}`}>
      <Combobox value={selected} onChange={(e) => setSelected(e)}>
        <div className="relative mt-1">
          <div className="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm">
            <Combobox.Input
              autoComplete="off"
              name='city'
              className="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
              displayValue={(city) => typeof selected.id === "number" ? `${city.name} (${city.zip_code})` : ''}
              onChange={(event) => setQuery(event.target.value)}
            />
            <Combobox.Button className="absolute inset-y-0 right-0 flex items-center pr-2">
              <ChevronUpDownIcon
                className="h-5 w-5 text-gray-400"
                aria-hidden="true"
              />
            </Combobox.Button>
          </div>
          <Transition
            as={Fragment}
            leave="transition ease-in duration-100"
            leaveFrom="opacity-100"
            leaveTo="opacity-0"
          >
            <Combobox.Options className="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
              {filteredCities.length === 0 && query !== '' || filteredCities.length === undefined ? (
                <div className="relative cursor-default select-none px-4 py-2 text-gray-700">
                  Nothing found.
                </div>
              ) : (
                filteredCities.map((city) => (
                  <Combobox.Option
                    key={city.id}
                    className={({ active }) =>
                      `relative cursor-default select-none py-2 pl-10 pr-4 ${
                        active ? 'bg-teal-600 text-white' : 'text-gray-900'
                      }`
                    }
                    value={city}
                  >
                    {({ selected, active }) => (
                      <>
                        <span
                          className={`block truncate ${
                            selected ? 'font-medium' : 'font-normal'
                          }`}
                        >
                          {`${city.name} (${city.zip_code})`}
                        </span>
                        {selected ? (
                          <span
                            className={`absolute inset-y-0 left-0 flex items-center pl-3 ${
                              active ? 'text-white' : 'text-teal-600'
                            }`}
                          >
                            <CheckIcon className="h-5 w-5" aria-hidden="true" />
                          </span>
                        ) : null}
                      </>
                    )}
                  </Combobox.Option>
                ))
              )}
            </Combobox.Options>
          </Transition>
        </div>
      </Combobox>
    </div>
  )
}
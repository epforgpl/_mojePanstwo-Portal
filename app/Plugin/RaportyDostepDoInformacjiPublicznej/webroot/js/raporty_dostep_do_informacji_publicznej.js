/*global G_vmlCanvasManager, _ADMIN*/
function InfoGraph() {
    this.infoData = {
        'id1': {
            'w': "Masz prawo uzyskiwania informacji",
            'a': "Przeszukaj Biuletyn Informacji Publicznej (BIP) i _mojePaństwo",
            'ta': "Biuletyn Informacji Publicznej to system stron internetowych, który ma umożliwić każdemu bezpłatny dostęp do informacji publicznej. To miejsce, w którym władze publiczne w formie elektronicznej publikują informacje o swojej działalności",
            'p': "Czy informacja której szukasz jest w BIP?",
            'o': {
                'id1000': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id2': {
            'w': "Informacja publiczna, której nie ma w BIP jest udostępniana na wniosek",
            'a': "Złóż wniosek do urzędu",
            'p': "Czy urząd odpowiedział w ciagu 14 dni?",
            'o': {
                'id3': {
                    'text': "tak",
                    'class': "yes"
                },
                'id4': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id3': {
            'p': "Co odpowiedział urząd?",
            'o': {
                'id5': {
                    'text': "Urząd wskazał, że informacja której szukasz znajduje się BIPie",
                    'class': "info",
                    'to': "Urząd powinien dokładnie określić, w którym miejscu w BIPie możesz znaleźć interesującą Cię informację"
                },
                'id1000': {
                    'text': "Urząd udostępnił informację zgodnie z Twoim wnioskiem",
                    'class': "info"
                },
                'id6': {
                    'text': "Urząd wydał decyzję o odmowie udostępnienia informacji",
                    'class': "info"
                },
                'id7': {
                    'text': "Urząd powiadomił, że informacja nie może być udostępniona w terminie 14 dni",
                    'class': "info",
                    'to': "Urząd wskazał też przyczyny opóźnienia i termin, w którym udostępni informację, nie dłuższy niż 2 miesiące od dnia złożenia wniosku"
                },
                'id8': {
                    'text': "Urząd powiadomił, że niemożliwe jest udzielenie informacji w sposób i w formie, którą określiłeś we wniosku",
                    'class': "info",
                    'to': "Urząd wskazał też na sposób i formę wniosku w jakich informację może udostępnić niezwłocznie"
                },
                'id9': {
                    'text': "Urząd zawiadomił, że należy wnieść opłatę",
                    'class': "info",
                    'to': "Opłata może być związana ze wskazanym we wniosku sposobem udostępnienia lub koniecznością przekształcenia informacji w formę wskazaną we wniosku"
                },
                'id10': {
                    'text': "Urząd zawiadomił, że informacja ma charakter informacji przetworzonej",
                    'class': "info",
                    'to': "Gdy urząd nie dysponuje w dniu złożenia Twojego wniosku gotową informacją i musiałby podjąć dodatkowe czynności polegające na sięgnięciu np. do dokumentacji źródłowej, żeby Ci ją udostepnić - wtedy jest to informacja przetworzona"
                },
                id4: {
                    'text': "Urząd udzielił innej niż wymienione odpowiedzi",
                    'class': "info"
                }
            }
        },
        'id4': { //schemat bezczynności
            'w': "Urząd nie załatwił sprawy w terminie",
            'tw': "Taki stan w języku prawniczym nazywany jest bezczynnością. Bezczynność zachodzi wtedy, gdy urząd przekracza termin załatwienia sprawy, bo nie podejmuje żadnych czynności, albo prowadzi postępowanie, i nie kończy go wydaniem decyzji lub podjęciem odpowiedniej czynności",
            'a': "Złóż skargę na bezczynność",
            'p': "Czy otrzymałeś pismo z informacją, że urząd przekazał sprawę do wojewódzkiego sądu administracyjnego?",
            'o': {
                'id11': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2002': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id5': {
            'w': "Prawdopodobnie nie przeszukałeś dokładnie BIP-u",
            'a': "Przeszukaj BIP jeszcze raz"
        },
        'id6': {
            'w': "Urząd uważa, że prawo dostępu do informacji, o którą prosisz ulega prawnym ograniczeniom",
            'a': "Odwołaj się od tej decyzji do organu odwoławczego",
            'ta': "Na odwołanie masz 14 dni od momentu otrzymania decyzji",
            'p': "Czy organ odwoławczy uwzględnił Twoje odwołanie?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id13': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id7': {
            'w': "Urząd potrzebuje więcej czasu, żeby Ci odpowiedzieć",
            'a': "Musisz poczekać",
            'ta': "Urząd w wyjątkowych sytuacjach ma prawo wydłużyć termin odpowiedzi na wniosek, np. dlatego, bo we wniosku zawarto pytania, które wymagają zasięgnięcia opinii różnych departamentów urzędu",
            'p': "Czy urząd odpowiedział w terminie, który wyznaczył udzielając wyczerpującej odpowiedzi?",
            'o': {
                'id1000': {
                    'text': "tak",
                    'class': "yes"
                },
                'id4': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id8': {
            'w': "Urząd twierdzi, że nie dysponuje odpowiednimi środkami technicznymi, by odpowiedzieć w sposób i w formie wskazanej przez Ciebie",
            'p': "Czy uważasz, że urząd ma rację?",
            'o': {
                'id14': {
                    'text': "tak",
                    'class': "yes"
                },
                'id15': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id9': {
            'w': "Urząd, by udostępnić Ci informację w postaci przez Ciebie wskazanej musiałby ponieść dodatkowe koszty",
            'p': "Czy jesteś gotowy je ponieść?",
            'tp': "Na zastanowienie masz 14 dni od otrzymania powiadomienia",
            'o': {
                'id16': {
                    'text': "tak",
                    'class': "yes"
                },
                'id17': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id10': {
            'w': "Urząd, by udostępnić Ci informację musiałby ją przetworzyć",
            'tw': "Urząd podejmie dodatkowe działania w celu przetworzenia informacji jeśli wykażesz w ciągu 14 dni, że uzyskanie określonej informacji jest szczególnie istotne dla interesu publicznego tzn. ma znaczenie z punktu widzenia funkcjonowania państwa",
            'p': "Wykazałeś szczególny interes publiczny?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2100': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id11': {
            'w': "Będzie rozprawa",
            'p': "Jaki był wynik rozprawy?",
            'o': {
                'id18': {
                    'text': "Uwzględnienie skargi",
                    'class': "info"
                },
                'id80': {
                    'text': "Oddalenie skargi",
                    'class': "info"
                },
                'id20': {
                    'text': "Odrzucenie skargi",
                    'class': "info"
                }
            }
        },
        'id13': {
            'i': "Urząd wydał decyzję o utrzymaniu w mocy zaskarżonej decyzji",
            'w': "Organ odwoławczy uważa, że prawo dostępu do informacji w Twojej sprawie ulega prawnym ograniczeniom",
            'a': "Złóż skargę na decyzję do wojewódzkiego sądu administracyjnego",
            'ta': "Skargę składa się za pośrednictwem organu, którego działanie zaskarżasz - masz na to 30 dni od dnia doręczenia Ci decyzji",
            'p': "Czy otrzymałeś informację, że organ przekazał sprawę do wojewódzkiego sądu administracyjnego?",
            'o': {
                'id23': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2013': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id14': {
            'a': "Zmień wniosek w zakresie sposobu i formy w ciągu 14 dni od otrzymania powiadomienia",
            'p': "Czy urząd odpowiedział niezwłocznie na zmodyfikowany wniosek udzielając wyczerpującej odpowiedzi?",
            'o': {
                'id1000': {
                    'text': "tak",
                    'class': "yes"
                },
                'id4': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id15': {
            'a': "Wyślij w ciągu 14 dni wniosek, w którym podtrzymujesz swoje dotychczasowe stanowisko",
            'p': "Czy urząd wydał decyzję o umorzeniu postępowania?",
            'o': {
                'id32': {
                    'text': "tak",
                    'class': "yes"
                },
                'id4': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id16': {
            'i': "Poinformuj urząd, że poniesiesz dodatkowe koszty",
            'w': "Urząd udostępnia informacje",
            'a': 'Uzyskasz informację i zostaniesz zobowiązany do poniesienia kosztów'
        },
        'id17': {
            'o': {
                'id900': {
                    'text': "Wycofaj wniosek",
                    'class': 'info'
                },
                'id33': {
                    'text': "Zmień wniosek w zakresie sposobu i formy udostępnienia",
                    'class': 'info'
                },
                'id34': {
                    'text': "Zaskarż wysokość opłaty, w tym celu najpierw wezwij urząd do usunięcia naruszenia prawa",
                    'to': "Masz na to 14 dni od dnia, w którym dowiedziałeś się lub mogłeś się dowiedzieć o wydaniu aktu o opłacie).",
                    'class': 'info'
                }

            }
        },
        'id18': {
            'w': "Wojewódzki sąd administracyjny uznał Twoje racje!",
            'tw': "W wyroku uwzględniającym skargę Sąd zobowiąże urząd do działania",
            'p': "Czy urząd wykonał wyrok?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id21': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id20': {
            'w': "Sąd uznał, że skarga zawierała wady",
            'tw': "Odrzucenie skargi oznacza zakończenie postępowania z przyczyn formalnych, np. gdy nie uzupełniono w wyznaczonym terminie braków skargi"
        },
        'id21': { //SCHEMAT SKARGI KASACYJNEJ
            'w': "Urząd nie wykonuje swojego obowiązku",
            'a': "Wezwij pisemnie urząd do wykonania wyroku",
            'p': "Czy po pisemnym wezwaniu urząd wykonał wyrok?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id22': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id22': {
            'w': "Urząd nie wykonuje swojego obowiązku",
            'a': "Wnieś skargę do sądu administracyjnego żądając wymierzenia grzywny dla urzędu",
            'ta': "Skargę złóż za pośrednictwem organu, który nie wykonuje wyroku"
        },
        'id23': {
            'w': "Będzie rozprawa",
            'p': "Jaki był wynik rozprawy?",
            'o': {
                'id25': {
                    'text': "Uwzględnienie skargi",
                    'class': "info"
                },
                'id26': {
                    'text': "Oddalenie skargi",
                    'class': "info"
                },
                'id20': {
                    'text': "Odrzucenie skargi",
                    'class': 'info'
                }
            }
        },
        'id25': {
            'w': "Wojewódzki sąd administracyjny uznał Twoje racje",
            'p': "Jaka była treść rozstrzygnięcia ?",
            'o': {
                'blank1': {
                    'text': "Uchylenie decyzji w całości lub w części",
                    'class': "info"
                },
                'blank2': {
                    'text': "Stwierdzenie nieważności decyzji w całości lub w części",
                    'class': "info"
                },
                'blank3': {
                    'text': "Stwierdzenie wydania decyzji z naruszeniem prawa",
                    'class': "info"
                }
            }
        },
        'id26': {
            'w': "Wojewódzki sąd administracyjny uznał, że Twoja skarga nie zasługuje na uwzględnienie",
            'a': "Złóż skargę kasacyjną do Naczelnego Sądu Administracyjnego",
            'ta': "Skargę składa się za pośrednictwem wojewódzkiego sądu administracyjnego - masz na to 30 dni od momentu doręczenia Ci wyroku z uzasadnieniem; skargę kasacyjną musi sporządzić adwokat lub radca prawny",
            'p': "Co orzekł Naczelny Sąd Administracyjny?",
            'o': {
                'id28': {
                    'text': "Uwzględnienie skargi kasacyjnej",
                    'class': "info"
                },
                'id29': {
                    'text': "Oddalenie skargi kasacyjnej",
                    'class': "info"
                },
                'id30': {
                    'text': "Uchylenie zaskarżonego orzeczenia i rozpoznanie skargi przez Naczelny Sąd Administracyjny",
                    'class': "info"
                },
                'id31': {
                    'text': "Uchylenie wydanego w sprawie orzeczenia oraz odrzucenie skargi lub umorzenie postępowania",
                    'class': "info"
                }
            }

        },
        'id28': {
            'w': "Uchylenie zaskarżonego orzeczenia w całości lub w części i przekazanie sprawy do ponownego rozpoznania sądowi, który wydał orzeczenie",
            'tw': "W razie gdyby ten sąd nie mógł ponownie rozpoznać sprawy w innym składzie - Naczelny Sąd Administracyjny przekaże ją innemu sądowi"
        },
        'id29': {
            'w': "Skarga kasacyjna nie ma usprawiedliwionych podstaw albo zaskarżone orzeczenie mimo błędnego uzasadnienia odpowiada prawu"
        },
        'id30': {
            'w': "Nie ma naruszeń przepisów postępowania, które mogły mieć istotny wpływ na wynik sprawy, a zachodzi jedynie naruszenie prawa materialnego"
        },
        'id31': {
            'w': "Skarga ulegała odrzuceniu albo istniały podstawy do umorzenia postępowania przed wojewódzkim sądem administracyjnym"
        },
        'id32': {
            'i': "Decyzja o umorzeniu postępowania",
            'w': "Urząd w takiej sytuacji powinien wydać decyzję o umorzeniu postępowania",
            'a': "Jesli nie zgadzasz się z urzędem możesz odwołać się od decyzji",
            'ta': "Masz na to 14 dni od momentu jej otrzymania",
            'p': "Czy organ odwoławczy uwzględnił odwołanie?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id50': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id33': {
            'p': "Czy urząd odpowiedział niezwłocznie na zmodyfikowany wniosek udzielając wyczerpującej odpowiedzi?",
            'o': {
                'id1000': {
                    'text': "tak",
                    'class': "yes"
                },
                'id4': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id34': {
            'p': "Jaka była reakcja urzędu na Twoje wezwanie?",
            'o': {
                'id35': {
                    'text': "Urząd uznał Twoje racje",
                    'to': "Urząd stwierdził, że faktycznie akt został przez niego podjęty z naruszeniem prawa",
                    'class': "info"
                },
                'id36': {
                    'text': "Urząd nie zgadza się z Twoim wezwaniem",
                    'class': "info"
                },
                'id37': {
                    'text': "Urząd nie odpowiada na Twoje wezwanie",
                    'class': "info"
                }
            }
        },
        'id35': {
            'w': 'Urząd uruchomi dostępne mu środki prawne służące przywróceniu stanu zgodnego z prawem'
        },
        'id36': {
            'a': "Złóż skargę do Wojewódzkiego Sądu Administracyjnego",
            'ta': "Skargę wnosi się w terminie trzydziestu dni od dnia doręczenia odpowiedzi urzędu na wezwanie do usunięcia naruszenia prawa; skargę składa się za pośrednictwem urzędu, którego działanie zaskarżasz",
            'p': "Czy otrzymałeś informację, że organ przekazał sprawę do wojewódzkiego sądu administracyjnego?",
            'o': {
                'id39': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2002': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id37': {
            'a': "Złóż skargę do Wojewódzkiego Sądu Administracyjnego",
            'ta': "Jeżeli urząd nie udzielił odpowiedzi na wezwanie, skargę wnosi się w terminie sześćdziesięciu dni od dnia wniesienia wezwania o usunięcie naruszenia prawa; skargę składa się za pośrednictwem urzędu, którego działanie zaskarżasz",
            'p': "Czy otrzymałeś informację, że organ przekazał sprawę do wojewódzkiego sądu administracyjnego?",
            'o': {
                'id39': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2002': {
                    'text': "nie",
                    'class': "no"
                }
            }

        },
        'id39': {
            'w': "Będzie rozprawa",
            'p': "Co zrobił sąd?",
            'o': {
                'id40': {
                    'text': "Sąd uwzględnia skargę",
                    'class': "info"
                },
                'id41': {
                    'text': "Sąd odrzuca skargę",
                    'class': "info"
                },
                'id26': {
                    'text': "Sąd oddala skargę",
                    'class': "info"
                }
            }
        },
        'id40': {
            'w': "Sąd uchyli akt dotyczący opłaty"
        },
        'id41': {
            'w': "Skarga zawierała błędy formalne (np. została wniesiona po terminie)"
        },
        'id50': {//schemat skargi go wsa i nas
            'i': "Organ odwoławczy wydał decyzję, którą podtrzymuje dotychczasową decyzję o umorzeniu postępowania",
            'w': "Organ odwoławczy uważa, że postępowanie powinno zostać umorzone",
            'a': "Złóż skargę na decyzję do wojewódzkiego sądu administracyjnego",
            'ta': "Skargę składa się za pośrednictwem organu, którego działanie zaskarżasz - na jej wniesienie masz 30 dni od dnia doręczenia Ci decyzji",
            'p': "Czy otrzymałeś informację, że organ przekazał sprawę do wojewódzkiego sądu administracyjnego?",
            'o': {
                'id51': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2013': {
                    'text': "nie",
                    'class': "no"
                }
            }

        },
        'id51': {
            'w': "Będzie rozprawa",
            'p': "Jaki był wynik rozprawy?",
            'o': {
                'id25': {
                    'text': "Uwzględnienie skargi",
                    'class': "info"
                },
                'id2205': {
                    'text': "Oddalenie skargi",
                    'class': "info"
                },
                'id20': {
                    'text': "Odrzucenie skargi",
                    'class': "info"
                }
            }
        },
        'id80': {
            'w': "Wojewódzki Sąd Administracyjny uznał, że Twoja skarga nie zasługuje na uwzględnienie",
            'a': "Złóż skargę kasacyjną do Naczelnego Sądu Administracyjnego",
            'ta': "Skargę kasacyjną składa się za pośrednictwem wojewódzkiego sądu administracyjnego, masz na to 30 dni od momentu doręczenia Ci wyroku z uzasadnieniem; skargę kasacyjną musi sporządzić adwokat lub radca prawny",
            'p': "Co orzekł Naczelny Sąd Administracyjny?",
            'o': {
                'id2009': {
                    'text': "Uwzględnienie skargi kasacyjnej",
                    'class': "info"
                },
                'id2010': {
                    'text': "Oddalenie skargi kasacyjnej",
                    'class': "info"
                },
                'id2011': {
                    'text': "Uchylenie zaskarżonego orzeczenia i rozpoznanie skargi przez Naczelny Sąd Administracyjny",
                    'class': "info"
                },
                'id2012': {
                    'text': "Uchylenie wydanego w sprawie orzeczenia oraz odrzucenie skargi lub umorzenie postępowania",
                    'class': "info"
                }
            }
        },
        'id900': {
            'w': "Decyzja o umorzeniu postępowania",
            'a': "Odwołaj się od decyzji",
            'ta': "Masz na to 14 dni od momentu jej otrzymania",
            'p': "Czy organ odwoławczy uwzględnił odwołanie?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2201': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id1000': {
            'w': "Masz informację !!!"
        },
        'id1001': {
            'w': "Sprawa wraca do organu I instancji, który ponownie będzie rozpatrywał Twój wniosek"
        },
        'id1002': {
            'w': "Uzyskasz informację i zostaniesz zobowiązany do poniesienia kosztów"
        },
        'id1003': {
            'w': "Organ I instancji ponownie zajmie się rozpatrzeniem Twojego wniosku"
        },
        'id2001': {
            'w': "Będzie rozprawa",
            'p': "Jaki był wynik rozprawy?",
            'o': {
                'id2003': {
                    'text': "Uwzględnienie skargi",
                    'class': 'info'
                },
                'id2004': {
                    'text': "Oddalenie skargi",
                    'class': 'info'
                },
                'id20': {
                    'text': "Odrzucenie skargi",
                    'class': 'info'
                }
            }
        },
        'id2002': {
            'w': "Urząd nie wypełnia prawa",
            'a': "Złóż wniosek o wymierzenie grzywny."
        },
        'id2003': {
            'w': "Wojewódzki sąd administracyjny uznał Twoje racje!",
            'tw': "W wyroku uwzględniającym skargę Sąd zobowiąże urząd do działania",
            'p': "Czy urząd wykonał wyrok?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2006': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id2004': {
            'w': "Wojewódzki sąd administracyjny uznał, że Twoja skarga nie zasługuje na uwzględnienie",
            'a': "Złóż skargę kasacyjną do Naczelnego Sądu Administracyjnego",
            'ta': "Skargę kasacyjną składa się za pośrednictwem wojewódzkiego sądu administracyjnego, masz na to 30 dni od momentu doręczenia Ci wyroku z uzasadnieniem; skargę kasacyjną musi sporządzić adwokat lub radca prawny",
            'p': "Co orzekł Naczelny Sąd Administracyjny?",
            'o': {
                'id2009': {
                    'text': "Uwzględnienie skargi kasacyjnej",
                    'class': "info"
                },
                'id2010': {
                    'text': "Oddalenie skargi kasacyjnej",
                    'class': "info"
                },
                'id2011': {
                    'text': "Uchylenie zaskarżonego orzeczenia i rozpoznanie skargi przez Naczelny Sąd Administracyjny",
                    'class': "info"
                },
                'id2012': {
                    'text': "Uchylenie wydanego w sprawie orzeczenia oraz odrzucenie skargi lub umorzenie postępowania",
                    'class': "info"
                }
            }
        },
        'id2006': {
            'w': "Urząd nie wykonuje swojego obowiązku",
            'a': "Wezwij pisemnie urząd do wykonania wyroku",
            'p': "Czy po pisemnym wezwaniu urząd wykonał wyrok?",
            'o': {
                'id1003': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2007': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id2007': {
            'w': "Urząd nie wykonuje swojego obowiązku",
            'a': "Wnieś skargę do wojewódzkiego sądu administracyjnego żądając wymierzenia grzywny dla urzędu",
            'ta': "Skargę złóż za pośrednictwem organu, który nie wykonuje wyroku"
        },
        'id2009': {
            'w': "Uchylenie zaskarżonego orzeczenia w całości lub w części i przekazanie sprawy do ponownego rozpoznania sądowi, który wydał orzeczenie",
            'tw': "W razie gdyby ten sąd nie mógł ponownie rozpoznać sprawy w innym składzie - Naczelny Sąd Administracyjny przekaże ją innemu sądowi"
        },
        'id2010': {
            'w': "Skarga kasacyjna nie ma usprawiedliwionych podstaw albo zaskarżone orzeczenie mimo błędnego uzasadnienia odpowiada prawu"
        },
        'id2011': {
            'w': "Nie ma naruszeń przepisów postępowania, które mogły mieć istotny wpływ na wynik sprawy, a zachodzi jedynie naruszenie prawa materialnego"
        },
        'id2012': {
            'w': "Skarga ulegała odrzuceniu albo istniały podstawy do umorzenia postępowania przed wojewódzkim sądem administracyjnym"
        },
        'id2013': {
            'w': "Organ nie wypełnia prawa",
            'a': "Złóż wniosek o wymierzenie grzywny."
        },
        'id2100': {
            'w': "Decyzja o odmowie udostępnienia informacji",
            'a': "Odwołaj się od decyzji",
            'ta': "Masz na to 14 dni od momentu jej otrzymania",
            'p': "Czy organ odwoławczy uwzględnił odwołanie?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2201': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id2200': {//schemat bezczynności

            'w': "Urząd w takiej sytuacji powinien wydać decyzję o umorzeniu postępowania",
            'a': "Odwołaj się od decyzji",
            'ta': "Masz na to 14 dni od momentu jej otrzymania",
            'p': "Czy organ odwoławczy uwzględnił odwołanie?",
            'o': {
                'id1001': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2201': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id2201': {
            'i': "Organ odwoławczy wydał decyzję podtrzymującą dotychczasową decyzję",
            'w': "Stanowisko organu odwoławczego jest inne niż Twoje",
            'a': "Złóż skargę na decyzję do wojewódzkiego sądu administracyjnego",
            'ta': "Skargę składa się za pośrednictwem organu, którego działanie zakarżasz - na jej wniesienie masz 30 dni od dnia doręczenia Ci decyzji",
            'p': "Czy otrzymałeś informacje, że organ przekazał sprawę do wojewódzkiego sądu administracyjnego?",
            'o': {
                'id2202': {
                    'text': "tak",
                    'class': "yes"
                },
                'id2013': {
                    'text': "nie",
                    'class': "no"
                }
            }
        },
        'id2202': {
            'w': "Będzie rozprawa",
            'p': "Jaki był wynik rozprawy?",
            'o': {
                'id2204': {
                    'text': "Uwzględnienie skargi",
                    'class': "info"
                },
                'id2205': {
                    'text': "Oddalenie skargi",
                    'class': "info"
                },
                'id20': {
                    'text': "Odrzucenie skargi",
                    'class': "info"
                }
            }
        },
        'id2204': {
            'w': "Wojewódzki sąd administracyjny uznał Twoje racje",
            'p': "Jaka była treść rozstrzygnięcia ?",
            'o': {
                'blank1': {
                    'text': "Uchylenie decyzji w całości lub w części",
                    'class': "info"
                },
                'blank2': {
                    'text': "Stwierdzenie nieważności decyzji w całości lub w części",
                    'class': "info"
                },
                'blank3': {
                    'text': "Stwierdzenie wydania decyzji z naruszeniem prawa",
                    'class': "info"
                }
            }
        },
        'id2205': {
            'w': "Wojewódzki sąd administracyjny uznał, że Twoja skarga nie zasługuje na uwzględnienie",
            'a': "Złóż skargę kasacyjną do Naczelnego Sądu Administracyjnego",
            'ta': "Skargę kasacyjną składa się za pośrednictwem wojewódzkiego sądu administracyjnego, na jej wniesienie masz 30 dni od momentu doręczenia Ci wyroku z uzasadnieniem; skargę kasacyjną musi sporządzić adwokat lub radca prawny",
            'p': "Co orzekł Naczelny Sąd Administracyjny?",
            'o': {
                'id2207': {
                    'text': "Uwzględnienie skargi kasacyjnej",
                    'class': "info"
                },
                'id2208': {
                    'text': "Oddalenie skargi kasacyjnej",
                    'class': "info"
                },
                'id2209': {
                    'text': "Uchylenie zaskarżonego orzeczenia i rozpoznanie skargi przez Naczelny Sąd Administracyjny",
                    'class': "info"
                },
                'id2210': {
                    'text': "Uchylenie wydanego w sprawie orzeczenia oraz odrzucenie skargi lub umorzenie postępowania",
                    'class': "info"
                }
            }
        },

        'id2207': {
            'w': "Uchylenie zaskarżonego orzeczenia w całości lub w części i przekazanie sprawy do ponownego rozpoznania sądowi, który wydał orzeczenie",
            'tw': "W razie gdyby ten sąd nie mógł ponownie rozpoznać sprawy w innym składzie - Naczelny Sąd Administracyjny przekaże ją innemu sądowi"
        },
        'id2208': {
            'w': "Skarga kasacyjna nie ma usprawiedliwionych podstaw albo zaskarżone orzeczenie mimo błędnego uzasadnienia odpowiada prawu"
        },
        'id2209': {
            'w': "Nie ma naruszeń przepisów postępowania, które mogły mieć istotny wpływ na wynik sprawy, a zachodzi jedynie naruszenie prawa materialnego"
        },
        'id2210': {
            'w': "Skarga ulegała odrzuceniu albo istniały podstawy do umorzenia postępowania przed wojewódzkim sądem administracyjnym"
        }
    };

    this.userDump = [];

    this.schema = {
        base: jQuery('.infoGraphContent'),
        baseHeight: 0,
        structure: []
    }
}

InfoGraph.prototype = {
    construct: InfoGraph,
    init: function () {
        this.createBlock('id1');
    },
    createBlock: function (idNumber) {
        var self = this,
            base = jQuery('<div></div>'),
            dataInfo = this.infoData[idNumber],
            aChoice,
            baseHeight;

        if (typeof _ADMIN != 'undefined' && _ADMIN)
            console.log('createBlock: started for ' + idNumber);

        base.addClass('thought ' + idNumber).data('id', idNumber);
        if ((typeof dataInfo['i'] !== "undefined" && dataInfo['i']) || (typeof dataInfo['w'] !== "undefined" && dataInfo['w']) || ((typeof dataInfo['a'] !== "undefined" && dataInfo['a']))) {
            var sBase = jQuery('<div></div>').addClass('statement');
            if ((typeof dataInfo['i'] !== "undefined" && dataInfo['i']))
                sBase.append(jQuery('<div></div>').addClass('information').text(dataInfo['i']));
            if ((typeof dataInfo['w'] !== "undefined" && dataInfo['w']))
                sBase.append(jQuery('<div></div>').addClass('title').text(dataInfo['w']));
            if ((typeof dataInfo['tw'] !== "undefined" && dataInfo['tw']))
                sBase.find('.title').append(jQuery('<i></i>').addClass('tips').attr('title', dataInfo['tw']));
            if (typeof dataInfo['a'] !== "undefined" && dataInfo['a']) {
                (typeof dataInfo['w'] == "undefined") ? sBase.append(jQuery('<div></div>').addClass('action big').text(dataInfo['a'])) : sBase.append(jQuery('<div></div>').addClass('action').text(dataInfo['a']));
            }
            if ((typeof dataInfo['ta'] !== "undefined" && dataInfo['ta']))
                sBase.find('.action').append(jQuery('<i></i>').addClass('tips').attr('title', dataInfo['ta']));
            base.append(sBase);
        }

        if (typeof dataInfo['p'] !== "undefined" && dataInfo['p']) {
            var qBase = jQuery('<div></div>').addClass('question');
            qBase.text(dataInfo['p']);
            if ((typeof dataInfo['tp'] !== "undefined" && dataInfo['tp']))
                qBase.append(jQuery('<i></i>').addClass('tips').attr('title', dataInfo['tp']));
            base.append(qBase);
        }
        if (typeof dataInfo['o'] !== "undefined" && dataInfo['o']) {
            var aBase = jQuery('<div></div>').addClass('answers');
            var i = 0;
            jQuery.each(dataInfo['o'], function (index, value) {
                if (i++ % 4 == 0) {
                    aBase.append('<div class="clearfix"></div>');
                }
                var aOnce = jQuery('<div></div>').addClass('crossRoad');
                aOnce.addClass(value['class']).data('exit', index).text(value['text']);
                if (index.match("^blank"))
                    aOnce.addClass('blank');
                if ((typeof value['to'] !== "undefined" && value['to']))
                    aOnce.append(jQuery('<i></i>').addClass('tips').attr('title', value['to']));
                aBase.append(aOnce);
            });
            base.append(aBase);
        }

        if (typeof _ADMIN != 'undefined' && _ADMIN)
            console.log('createBlock: node structure - ' + jQuery(base));

        this.schema.base.append(base.css({
            'position': 'absolute',
            'top': '0',
            'left': '-99999px'
        }));
        this.schema.baseHeight += base.outerHeight();
        baseHeight = (this.schema.baseHeight > base.outerHeight()) ? this.schema.baseHeight : base.outerHeight();
        if (typeof sBase !== "undefined" && sBase)
            sBase.hide();
        if (typeof qBase !== "undefined" && qBase)
            qBase.hide();
        if (typeof aBase !== "undefined" && aBase)
            aBase.hide();
        base.css({
            'position': 'relative',
            'top': 0,
            'left': 0
        });
        this.schema.base.animate({
            'height': baseHeight
        }, 800, function () {
            if (typeof sBase !== "undefined" && sBase) {
                sBase.flippy({
                    duration: "1200",
                    onStart: function () {
                        if (typeof sBase !== "undefined" && sBase)
                            sBase.fadeIn();
                    },
                    onFinish: function () {
                        if (typeof qBase !== "undefined" && qBase) {
                            qBase.fadeIn(600, function () {
                                if (typeof aBase !== "undefined" && aBase)
                                    aBase.fadeIn(600);
                            });
                        } else {
                            if (typeof aBase !== "undefined" && aBase)
                                aBase.fadeIn(600);
                        }
                    }
                });
            } else {
                if (typeof qBase !== "undefined" && qBase) {
                    qBase.fadeIn(600, function () {
                        if (typeof aBase !== "undefined" && aBase)
                            aBase.fadeIn(600);
                    });
                } else {
                    if (typeof aBase !== "undefined" && aBase)
                        aBase.fadeIn(600);
                }
            }
            if (typeof aBase !== "undefined" && aBase) {
                aChoice = aBase.find('.crossRoad');
                aChoice.click(function (e) {
                    var that = jQuery(this);
                    e.preventDefault();

                    if (that.hasClass('active') || that.hasClass('blank')) {
                        e.stopPropagation();
                    } else {
                        (that.hasClass('disabled')) ? self.recreatePath(idNumber, e) : self.createPath(idNumber, e);
                        aChoice.addClass('disabled').removeClass('active');
                        that.removeClass('disabled').addClass('active');
                    }
                })
            }

            base.find('.tips').tooltip({
                position: {
                    my: "center top",
                    at: "center+5 bottom+15",
                    using: function (position, feedback) {
                        jQuery(this).css(position);
                        jQuery("<div>")
                            .addClass("arrow")
                            .addClass(feedback.vertical)
                            .addClass(feedback.horizontal)
                            .appendTo(this);
                    }
                }
            });
        });

    },
    createPath: function (idNumber, e) {
        var node = jQuery(e.target),
            nodePos = {top: node.position().top + 10, left: node.position().left + 10},
            nodeWidth = node.outerWidth(),
            nodeHeight = node.outerHeight(),
            parent = jQuery('.thought.' + idNumber).find('.answers'),
            parentWidth = parent.outerWidth(),
            parentHeight = parent.outerHeight(),
            canvasId = idNumber + '-' + this.userDump.length,
            pathString;
        e.preventDefault();

        if (typeof _ADMIN != 'undefined' && _ADMIN)
            console.log('createPath: started for ' + idNumber + ', element ' + e);

        parent.append(
            jQuery('<div></div>').css({
                width: parentWidth,
                height: parentHeight,
                position: 'absolute',
                top: 0,
                left: 0
            })
                .attr('id', canvasId)
                .data('slot', this.userDump.length)
                .addClass('canvas')
        );

        var canvas = Raphael(canvasId, parentWidth, parentHeight);

        if (jQuery(e.target).hasClass('info')) {
            pathString = 'M' + Math.floor(parentWidth / 2) + ' ' + Math.floor(nodePos.top + (nodeHeight / 2))
            + 'L' + Math.floor(parentWidth / 2) + ' ' + Math.floor(parentHeight);
        } else {
            pathString = 'M' + Math.floor(nodePos.left + (nodeWidth / 2)) + ' ' + Math.floor(nodePos.top + (nodeHeight / 2))
            + 'L' + Math.floor(nodePos.left + (nodeWidth / 2)) + ' ' + Math.floor(nodePos.top + (nodeHeight / 2) + ((parentHeight - nodePos.top) / 2))
            + 'L' + Math.floor(parentWidth / 2) + ' ' + Math.floor(nodePos.top + (nodeHeight / 2) + ((parentHeight - nodePos.top) / 2))
            + 'L' + Math.floor(parentWidth / 2) + ' ' + Math.floor(parentHeight);
        }
        this.animatePath(canvas, "#fff", pathString, node.data('exit'));
        this.userDump.push({idNumber: idNumber, node: node});

        if (typeof _ADMIN != 'undefined' && _ADMIN)
            console.log('createPath: added user choice - ' + node + ' to ' + this.userDump);

        $("html, body").stop(true, false).animate({scrollTop: $(document).height()}, 1000);
    },
    recreatePath: function (idNumber, e) {
        var self = this,
            parent = jQuery('.thought.' + idNumber),
            canvas = parent.find('.answers .canvas'),
            slot = canvas.data('slot'),
            allowGeneratePath = true;

        if (typeof _ADMIN != 'undefined' && _ADMIN)
            console.log('recreatePath: started' + idNumber + ', element ' + e);

        parent.find('.answers .canvas').remove();
        parent.nextAll().fadeOut(400, function () {
            parent.nextAll().remove();

            var baseHeight = 0;
            self.schema.base.find('.thought:visible').each(function () {
                baseHeight += jQuery(this).outerHeight();
            });
            if (allowGeneratePath) {
                allowGeneratePath = false;
                self.schema.baseHeight = baseHeight;
                self.schema.base.animate({
                    'height': self.schema.baseHeight
                }, function () {
                    self.userDump = self.userDump.slice(0, slot);
                    self.createPath(idNumber, e);

                    if (typeof _ADMIN != 'undefined' && _ADMIN)
                        console.log('recreatePath: rebuild user choice ' + self.userDump);

                    allowGeneratePath = true;
                });
            }
        });
        $("html, body").stop(true, false).animate({scrollTop: $(document).height()}, 1000);
    },

    animatePath: function (canvas, colorNumber, pathString, exit) {
        var self = this,
            nextRender = false,
            line = canvas.path(pathString).attr({
                'stroke': colorNumber,
                'stroke-width': 3
            }),
            length = line.getTotalLength();

        if (typeof _ADMIN != 'undefined' && _ADMIN)
            console.log('animatePath: started');

        jQuery('path[fill*="none"]').animate({
            'to': 1
        }, {
            duration: 1000,
            step: function (pos, fx) {
                var offset = length * fx.pos;
                var subpath = line.getSubpath(0, offset);
                canvas.clear();
                canvas.path(subpath).attr({
                    'stroke': colorNumber,
                    'stroke-width': 3
                });

                if (fx.pos > 0.25 && exit && !nextRender) {
                    self.createBlock(exit);
                    nextRender = true;

                    if (typeof _ADMIN != 'undefined' && _ADMIN)
                        console.log('animatePath: start animate new node ' + exit);
                }
            }
        });
    }
};

(function ($) {
    function detect_CSS3Support() {
        $("document").ready(function () {
            var Fel = document.createElement('p'),
                support_css3,
                transforms = {
                    'webkitTransform': '-webkit-transform',
                    'OTransform': '-o-transform',
                    'msTransform': '-ms-transform',
                    'MozTransform': '-moz-transform',
                    'transform': 'transform'
                };
            document.body.appendChild(Fel);

            for (var t in transforms) {
                if (transforms.hasOwnProperty(t)) {
                    if (Fel.style[t] !== undefined) {
                        Fel.style[t] = 'rotateX(1deg)';
                        support_css3 = window.getComputedStyle(Fel, null).getPropertyValue(transforms[t]);
                    }
                }
            }

            document.body.removeChild(Fel);

            _Support_CSS3 = (support_css3 !== undefined && support_css3.length > 0 && support_css3 !== "none");
        });
    }

    var _isIE = (navigator.appName == "Microsoft Internet Explorer");
    var _Support_Canvas = window.HTMLCanvasElement;
    var _Support_CSS3 = null;
    detect_CSS3Support();
    var PI = Math.PI;

    //! Class flipBox
    var flipBox = function ($jO, opts) {
        this.animate = function () {
            this._Before();

            if (!_Support_CSS3) {
                this.initiateFlippy();
                this.cvO = document.getElementById("flippy" + this._UID);
                this.jO.data("_oFlippy_", this);
                this._Int = setInterval($.proxy(this.drawFlippy, this), this._Refresh_rate);
            } else {
                this.jO
                    .addClass('flippy_active')
                    .parent()
                    .css({
                        "perspective": this._nW + "px"
                    });
                this.jO.data("_oFlippy_", this);
                this._Int = setInterval($.proxy(this.drawFlippyCSS, this), this._Refresh_rate);
            }

        };

        this.drawFlippyCSS = function () {
            this._Ang = this._Ang - this._Step_ang;

            if (this._Ang <= 0) {
                this.jO
                    .removeClass("flippy_active")
                    .css({
                        "-webkit-transform": "rotateX(0deg)",
                        "-moz-transform": "rotateX(0deg)",
                        "-o-transform": "rotateX(0deg)",
                        "-ms-transform": "rotateX(0deg)",
                        "transform": "rotateX(0deg)"
                    });

                clearInterval(this._Int);
                this._After();

                return;
            } else {
                this.jO.css({
                    "-webkit-transform": "rotateX(" + this._Ang + "deg)",
                    "-moz-transform": "rotateX(" + this._Ang + "deg)",
                    "-o-transform": "rotateX(" + this._Ang + "deg)",
                    "-ms-transform": "rotateX(" + this._Ang + "deg)",
                    "transform": "rotateX(" + this._Ang + "deg)"
                });
            }

            this._During();

        };

        this.initiateFlippy = function () {
            var cv_pattern;
            this.jO
                .addClass('flippy_active')
                .empty()
                .css({
                    "position": "relative",
                    "overflow": "visible"
                });

            this._CenterX = (Math.sin(PI / 2) * this._nW * this._Depth);
            this._CenterY = this._H / 2;
            cv_pattern = '<canvas id="flippy' + this._UID + '" class="flippy" width="' + (this._W + (2 * this._CenterX)) + '" height="' + this._H + '"></canvas>';
            this.new_flippy(cv_pattern);
            this.jO.find("#flippy" + this._UID)
                .css({
                    "position": "absolute",
                    "top": "0",
                    "left": "-" + this._CenterX + "px"
                });
        };

        this.drawFlippy = function () {
            this._Ang = (this._Ang > (75 + this._Step_ang)) ? this._Ang - (75 + this._Step_ang) : this._Ang;

            var rad = (this._Ang / 75) * PI;

            if (this.cvO === null) {
                return;
            }
            if (_isIE && !_Support_Canvas) {
                G_vmlCanvasManager.initElement(this.cvO);
            }
            var ctx = this.cvO.getContext("2d");
            ctx.clearRect(0, 0, this._W + (2 * this._CenterX), this._H + (2 * this._CenterY));
            ctx.beginPath();
            var deltaW = Math.sin(rad) * this._W * this._Depth;
            var Y;

            Y = Math.cos(rad) * (this._H / 2);
            ctx.moveTo(this._CenterX + deltaW, this._CenterY - Y);
            ctx.lineTo(this._CenterX - deltaW, this._CenterY + Y);
            ctx.lineTo(this._CenterX + this._W + deltaW, this._CenterY + Y);
            ctx.lineTo(this._CenterX + this._W - deltaW, this._CenterY - Y);
            ctx.lineTo(this._CenterX, this._CenterY - Y);
            ctx.fill();

            if (this._Ang > 75) {
                this.jO
                    .removeClass("flippy_active flippy_container")
                    .find(".flippy")
                    .remove();

                clearInterval(this._Int);
                this._After();

                return;
            }

            this._During();

        };

        this.new_flippy = function (cv_pattern) {
            if (_isIE && !_Support_Canvas) {

                this.jO
                    .addClass("flippy_container")
                    .attr("id", "flippy_container" + this._UID);
                var $that = document.getElementById("flippy_container" + this._UID);
                var cv = document.createElement(cv_pattern);

                $that.appendChild(cv);
            } else {
                this.jO.append(cv_pattern);
            }
        };

        opts = $.extend({
            step_ang: 10,
            refresh_rate: 15,
            duration: 300,
            depth: 0.12,
            onStart: function () {
            },
            onAnimation: function () {
            },
            onFinish: function () {
            }
        }, opts);

        this._UID = Math.floor(Math.random() * 1000000);
        this.jO = $jO;
        this._Ang = 75;
        this._Step_ang = (opts.refresh_rate / opts.duration) * 200;
        this._Refresh_rate = opts.refresh_rate;
        this._Depth = opts.depth;
        this._Before = opts.onStart;
        this._During = opts.onAnimation;
        this._After = opts.onFinish;
        this._nW = this.jO.width();
        this._W = this.jO.outerWidth();
        this._H = this.jO.outerHeight();
        opts = null;

    };

    $.fn.flippy = function (opts) {

        return this.each(function () {
            var $t = $(this);
            if (!$t.hasClass("flippy_active")) {
                var _FP = new flipBox($t, opts);
                _FP.animate();
            }
        });
    };

    /*INIT*/
    var iG = new InfoGraph();
    iG.init();
})(jQuery);
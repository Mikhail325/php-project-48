### Hexlet tests and linter status:
[![Actions Status](https://github.com/Mikhail325/php-project-48/workflows/hexlet-check/badge.svg)](https://github.com/Mikhail325/php-project-48/actions)
[![Actions Status](https://github.com/Mikhail325/php-project-48/actions/workflows/testGit.yml/badge.svg)](https://github.com/Mikhail325/php-project-48/actions)
<a href="https://codeclimate.com/github/Mikhail325/php-project-48/test_coverage"><img src="https://api.codeclimate.com/v1/badges/820227954b0c00504ddb/test_coverage" /></a>

## Вычислитель отличий
Вычислитель отличий – программа, определяющая разницу между двумя структурами данных. Это популярная задача, для решения которой существует множество онлайн-сервисов, например: http://www.jsondiff.com/. Подобный механизм используется при выводе тестов или при автоматическом отслеживании изменении в конфигурационных файлах.

Возможности утилиты:
* Поддержка разных входных форматов: yaml и json;
* Генерация отчета в виде plain text, stylish и json.

### Минимальные требования
* Composer >= 2.2;
* GNU Make >= 4.3

### Инструкции по установке и использованию
Для установки зависимостей используйте команду **make install**.
```
Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
```

### Нахождение различий плоских Yml и Json фалов
[![asciicast](https://asciinema.org/a/5JAsxCZqeChfvbr2XN5hxAEXi.svg)](https://asciinema.org/a/5JAsxCZqeChfvbr2XN5hxAEXi)

### Нахождение различий для файлов Yml и Json, имеющих вложенные структуры:
## Формат stylish
[![asciicast](https://asciinema.org/a/qUykV8Z5eJ9wzj7HM23QDYi11.svg)](https://asciinema.org/a/qUykV8Z5eJ9wzj7HM23QDYi11)
## Формат plain text
[![asciicast](https://asciinema.org/a/Cz7DGnGIHeLwxRAgRKrhQDJaN.svg)](https://asciinema.org/a/Cz7DGnGIHeLwxRAgRKrhQDJaN)
## Формат json
[![asciicast](https://asciinema.org/a/iDLRPaMYr12lf4CTN47uBRx7d.svg)](https://asciinema.org/a/iDLRPaMYr12lf4CTN47uBRx7d)

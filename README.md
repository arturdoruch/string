# StringUtil

String utilities.

## Installation

```
composer require arturdoruch/string-util
```

## Contents

  - `StringUtils`
  - `StringCaseConverter` 
  - `CharsetUtils` 
  
### Class API  
  
  - `StringUtils` methods:
  
    - contains
    - containsPattern
    - startsWith
    - endsWith
    - find
    - findAll
    - removeEmptyLines 
    
  - `StringCaseConverter` methods:
  
    - toPascal
    - toCamel
    - toSnake
    - toKebab
    - toTitle
    - toFilename
  
  - `CharsetUtils` methods:
  
    - isUtf8
    - cleanupUtf8
    - decodeHexCodePoints
    - decodeNonBreakingSpaces
    - removeAccents
    
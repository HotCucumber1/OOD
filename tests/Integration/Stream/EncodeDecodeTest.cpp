#include <catch2/catch_all.hpp>

#include "../../../src/Lab3/Stream/Output/EncryptDecorator.h"
#include "../../../src/Lab3/Stream/Output/FileOutputStream.h"
#include "../../../src/Lab3/Stream/Input/DecryptDecorator.h"
#include "../../../src/Lab3/Stream/Input/FileInputStream.h"

TEST_CASE("Encrypt-Decrypt")
{
    SECTION("Text data encryption and decryption")
    {
        std::stringstream stream;

        const uint8_t encryptionKey = 42;
        const std::string originalText = "Hello World! This is a test string with numbers: 12345 and symbols: !@#$%";

    	auto file_output = std::make_unique<FileOutputStream>(stream);
    	auto encryptor = std::make_unique<EncryptDecorator>(std::move(file_output), encryptionKey);

    	encryptor->WriteBlock(originalText.data(), originalText.size());
    	encryptor->Close();

        std::string encryptedData = stream.str();

        REQUIRE(encryptedData.size() == originalText.size());
        REQUIRE(encryptedData != originalText);

        stream.seekg(0);

    	auto fileInput = std::make_unique<FileInputStream>(stream);
    	auto decryptor = std::make_unique<DecryptDecorator>(std::move(fileInput), encryptionKey);

    	std::vector<uint8_t> decryptedBuffer(originalText.size());
    	std::streamsize bytesRead = decryptor->ReadBlock(decryptedBuffer.data(), decryptedBuffer.size());

    	REQUIRE(bytesRead == originalText.size());

    	std::string decrypted_text(decryptedBuffer.begin(), decryptedBuffer.end());

    	REQUIRE(decrypted_text == originalText);
    	REQUIRE(decryptor->IsEOF() == true);
    }

    SECTION("Mixed WriteByte/WriteBlock and ReadByte/ReadBlock")
    {
        std::stringstream stream;
        const uint8_t encryptionKey = 77;
        const std::string originalText = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    	auto file_output = std::make_unique<FileOutputStream>(stream);
    	auto encryptor = std::make_unique<EncryptDecorator>(std::move(file_output), encryptionKey);

    	encryptor->WriteByte('A');
    	encryptor->WriteByte('B');
    	encryptor->WriteByte('C');

    	std::string block1 = "DEFGHI";
    	encryptor->WriteBlock(block1.data(), block1.size());

    	encryptor->WriteByte('J');
    	encryptor->WriteByte('K');

    	std::string block2 = "LMNOP";
    	encryptor->WriteBlock(block2.data(), block2.size());

    	std::string block3 = "QRSTUVWXYZ";
    	encryptor->WriteBlock(block3.data(), block3.size());

    	encryptor->Close();

        stream.seekg(0);

    	auto file_input = std::make_unique<FileInputStream>(stream);
    	auto decryptor = std::make_unique<DecryptDecorator>(std::move(file_input), encryptionKey);

    	std::string decryptedText;

    	decryptedText.push_back(decryptor->ReadByte());
    	decryptedText.push_back(decryptor->ReadByte());
    	decryptedText.push_back(decryptor->ReadByte());

    	std::vector<uint8_t> buffer1(6);
    	std::streamsize bytesRead1 = decryptor->ReadBlock(buffer1.data(), buffer1.size());
    	REQUIRE(bytesRead1 == 6);
    	decryptedText.append(buffer1.begin(), buffer1.end());

    	decryptedText.push_back(decryptor->ReadByte());
    	decryptedText.push_back(decryptor->ReadByte());

    	std::vector<uint8_t> buffer2(5);
    	std::streamsize bytesRead2 = decryptor->ReadBlock(buffer2.data(), buffer2.size());
    	REQUIRE(bytesRead2 == 5);
    	decryptedText.append(buffer2.begin(), buffer2.end());

    	std::vector<uint8_t> buffer3(10);
    	std::streamsize bytes_read3 = decryptor->ReadBlock(buffer3.data(), buffer3.size());
    	REQUIRE(bytes_read3 == 10);
    	decryptedText.append(buffer3.begin(), buffer3.end());

    	REQUIRE(decryptedText == originalText);
    	REQUIRE(decryptor->IsEOF() == true);
    }

    SECTION("Different keys should not decrypt correctly")
    {
        std::stringstream stream;
        const uint8_t encryptKey = 50;
        const uint8_t wrongDecryptKey = 60;
        const std::string originalText = "Secret Message";

    	auto file_output = std::make_unique<FileOutputStream>(stream);
    	auto encryptor = std::make_unique<EncryptDecorator>(std::move(file_output), encryptKey);

    	encryptor->WriteBlock(originalText.data(), originalText.size());
    	encryptor->Close();

        stream.seekg(0);

    	auto file_input = std::make_unique<FileInputStream>(stream);
    	auto decryptor = std::make_unique<DecryptDecorator>(std::move(file_input), wrongDecryptKey);

    	std::vector<uint8_t> decrypted_buffer(originalText.size());
    	std::streamsize bytes_read = decryptor->ReadBlock(decrypted_buffer.data(), decrypted_buffer.size());

    	REQUIRE(bytes_read == originalText.size());

    	std::string decrypted_text(decrypted_buffer.begin(), decrypted_buffer.end());

    	REQUIRE(decrypted_text != originalText);
    }

    SECTION("Empty data encryption and decryption")
    {
        std::stringstream stream;
        const uint8_t encryptionKey = 33;

    	auto file_output = std::make_unique<FileOutputStream>(stream);
    	auto encryptor = std::make_unique<EncryptDecorator>(std::move(file_output), encryptionKey);

    	encryptor->WriteBlock(nullptr, 0);
    	encryptor->Close();

        REQUIRE(stream.str().empty());

        stream.seekg(0);

    	auto file_input = std::make_unique<FileInputStream>(stream);
    	auto decryptor = std::make_unique<DecryptDecorator>(std::move(file_input), encryptionKey);

    	REQUIRE(decryptor->IsEOF() == true);

    	std::vector<uint8_t> buffer(10);
    	std::streamsize bytes_read = decryptor->ReadBlock(buffer.data(), buffer.size());

    	REQUIRE(bytes_read == 0);
    	REQUIRE_THROWS_AS(decryptor->ReadByte(), std::exception);
    }
}
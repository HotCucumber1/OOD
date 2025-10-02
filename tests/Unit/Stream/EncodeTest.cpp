#include <catch2/catch_all.hpp>

#include "../../../src/Lab3/Stream/Output/EncryptDecorator.h"
#include "../../../src/Lab3/Stream/Output/FileOutputStream.h"

TEST_CASE("WriteByte encryption")
{
	std::ostringstream stream;
	auto fileOutput = std::make_unique<FileOutputStream>(stream);
	EncryptDecorator encryptor(std::move(fileOutput), 42);

	SECTION("Encrypt single bytes")
	{
		Cipher cipher(42);

		encryptor.WriteByte('A');
		encryptor.WriteByte('B');
		encryptor.WriteByte('C');
		encryptor.Close();

		std::string result = stream.str();
		REQUIRE(result.size() == 3);

		REQUIRE(static_cast<uint8_t>(result[0]) == cipher.Encrypt('A'));
		REQUIRE(static_cast<uint8_t>(result[1]) == cipher.Encrypt('B'));
		REQUIRE(static_cast<uint8_t>(result[2]) == cipher.Encrypt('C'));
	}
}

TEST_CASE("WriteBlock encryption")
{
	std::ostringstream stream;
	auto fileOutput = std::make_unique<FileOutputStream>(stream);
	EncryptDecorator encryptor(std::move(fileOutput), 123);

	SECTION("Encrypt block of data")
	{
		Cipher cipher(123);
		std::string data = "Hello World";

		encryptor.WriteBlock(data.data(), data.size());
		encryptor.Close();

		std::string result = stream.str();
		REQUIRE(result.size() == data.size());

		for (size_t i = 0; i < data.size(); ++i)
		{
			REQUIRE(static_cast<uint8_t>(result[i]) == cipher.Encrypt(static_cast<uint8_t>(data[i])));
		}
		REQUIRE(result != data);
	}

	SECTION("Encrypt empty block")
	{
		std::string data = "Test";
		encryptor.WriteBlock(data.data(), 0);
		encryptor.WriteBlock(data.data(), data.size());
		encryptor.Close();

		std::string result = stream.str();
		REQUIRE(result.size() == data.size());
	}
}

TEST_CASE("WriteBlock with null buffer")
{
	std::ostringstream stream;
	auto fileOutput = std::make_unique<FileOutputStream>(stream);
	EncryptDecorator encryptor(std::move(fileOutput), 55);

	SECTION("Null buffer with positive size should throw")
	{
		REQUIRE_THROWS_AS(encryptor.WriteBlock(nullptr, 5), std::exception);

		std::string data = "Test";
		encryptor.WriteBlock(data.data(), data.size());
		encryptor.Close();

		REQUIRE(stream.str().size() == data.size());
	}

	SECTION("Null buffer with zero size is allowed")
	{
		encryptor.WriteBlock(nullptr, 0);

		std::string data = "Data";
		encryptor.WriteBlock(data.data(), data.size());
		encryptor.Close();

		REQUIRE(stream.str().size() == data.size());
	}
}

TEST_CASE("Different encryption keys")
{
	SECTION("Different keys produce different encryption")
	{
		std::ostringstream stream1, stream2;

		auto output1 = std::make_unique<FileOutputStream>(stream1);
		EncryptDecorator encryptor1(std::move(output1), 10);

		auto output2 = std::make_unique<FileOutputStream>(stream2);
		EncryptDecorator encryptor2(std::move(output2), 20);

		std::string data = "SameData";
		encryptor1.WriteBlock(data.data(), data.size());
		encryptor2.WriteBlock(data.data(), data.size());

		encryptor1.Close();
		encryptor2.Close();

		std::string result1 = stream1.str();
		std::string result2 = stream2.str();

		REQUIRE(result1.size() == data.size());
		REQUIRE(result2.size() == data.size());
		REQUIRE(result1 != result2);
	}

	SECTION("Same keys produce same encryption")
	{
		std::ostringstream stream1, stream2;

		auto output1 = std::make_unique<FileOutputStream>(stream1);
		EncryptDecorator encryptor1(std::move(output1), 50);

		auto output2 = std::make_unique<FileOutputStream>(stream2);
		EncryptDecorator encryptor2(std::move(output2), 50);

		std::string data = "TestData";
		encryptor1.WriteBlock(data.data(), data.size());
		encryptor2.WriteBlock(data.data(), data.size());

		encryptor1.Close();
		encryptor2.Close();

		REQUIRE(stream1.str() == stream2.str());
	}
}

TEST_CASE("Close method behavior")
{
	std::ostringstream stream;

	SECTION("Close after writes")
	{
		auto fileOutput = std::make_unique<FileOutputStream>(stream);
		EncryptDecorator encryptor(std::move(fileOutput), 33);

		encryptor.WriteByte('A');
		encryptor.WriteByte('B');
		encryptor.Close();

		REQUIRE(stream.str().size() == 2);

		encryptor.Close();
		REQUIRE(stream.str().size() == 2);
	}

	SECTION("Close without writes")
	{
		auto fileOutput = std::make_unique<FileOutputStream>(stream);
		EncryptDecorator encryptor(std::move(fileOutput), 33);
		encryptor.Close();

		REQUIRE(stream.str().empty());
	}

	SECTION("Write after close")
	{
		auto fileOutput = std::make_unique<FileOutputStream>(stream);
		EncryptDecorator encryptor(std::move(fileOutput), 33);

		encryptor.WriteByte('X');
		encryptor.Close();

		REQUIRE_THROWS_AS(encryptor.WriteByte('Y'), std::exception);
		REQUIRE_THROWS_AS(encryptor.WriteBlock("test", 4), std::exception);

		REQUIRE(stream.str().size() == 1);
	}
}


TEST_CASE("Error propagation")
{
	std::ostringstream stream;

	SECTION("Error in underlying stream propagates")
	{
		auto fileOutput = std::make_unique<FileOutputStream>(stream);
		EncryptDecorator encryptor(std::move(fileOutput), 44);

		stream.setstate(std::ios::badbit);

		REQUIRE_THROWS_AS(encryptor.WriteByte('A'), std::exception);
		REQUIRE_THROWS_AS(encryptor.WriteBlock("test", 4), std::exception);
	}
}

